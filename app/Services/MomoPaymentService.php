<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class MomoPaymentService
{
    public function createPayment(Order $order, string $redirectUrl, string $ipnUrl): array
    {
        $partnerCode = (string) config('services.momo.partner_code');
        $accessKey = (string) config('services.momo.access_key');
        $secretKey = (string) config('services.momo.secret_key');
        $endpoint = (string) config('services.momo.endpoint');

        if ($partnerCode === '' || $accessKey === '' || $secretKey === '' || $endpoint === '') {
            throw new RuntimeException('Thiếu cấu hình MoMo trong file .env.');
        }

        $requestId = $order->momo_pay_url ? $order->momo_request_id : null;
        $momoOrderId = $order->momo_pay_url ? $order->momo_order_id : null;
        $requestId = $requestId ?: $this->buildRequestId($order);
        $momoOrderId = $momoOrderId ?: $this->buildMomoOrderId($order);
        $amount = (string) $this->momoAmount($order);
        $requestType = 'captureWallet';
        $extraData = base64_encode(json_encode([
            'order_id' => $order->id,
        ], JSON_UNESCAPED_SLASHES));

        $payload = [
            'partnerCode' => $partnerCode,
            'requestType' => $requestType,
            'ipnUrl' => $ipnUrl,
            'redirectUrl' => $redirectUrl,
            'orderId' => $momoOrderId,
            'amount' => $amount,
            'orderInfo' => 'Thanh toan don hang #'.$order->id,
            'requestId' => $requestId,
            'extraData' => $extraData,
            'autoCapture' => true,
            'lang' => 'vi',
        ];

        $payload['signature'] = $this->signatureForCreateRequest($payload);

        $order->forceFill([
            'momo_order_id' => $momoOrderId,
            'momo_request_id' => $requestId,
        ])->save();

        $response = Http::timeout(30)
            ->acceptJson()
            ->asJson()
            ->post($endpoint, $payload);

        $data = $response->json() ?? [];

        if ($response->failed()) {
            throw new RuntimeException($this->formatErrorMessage($response->status(), $data, $response->body()));
        }

        if ($response->failed()) {
            throw new RuntimeException('MoMo trả về lỗi HTTP '.$response->status().'.');
        }

        if ((int) ($data['resultCode'] ?? -1) !== 0 || empty($data['payUrl'])) {
            throw new RuntimeException($data['message'] ?? 'MoMo không tạo được link thanh toán.');
        }

        return array_merge($data, [
            'momo_order_id' => $momoOrderId,
            'momo_request_id' => $requestId,
            'request_payload' => $payload,
        ]);
    }

    public function verifyCallback(array $payload): bool
    {
        $signature = (string) ($payload['signature'] ?? '');

        if ($signature === '') {
            return false;
        }

        return hash_equals($signature, $this->signatureForCallback($payload));
    }

    protected function signatureForCreateRequest(array $payload): string
    {
        $rawSignature = implode('&', [
            'accessKey='.config('services.momo.access_key'),
            'amount='.$payload['amount'],
            'extraData='.$payload['extraData'],
            'ipnUrl='.$payload['ipnUrl'],
            'orderId='.$payload['orderId'],
            'orderInfo='.$payload['orderInfo'],
            'partnerCode='.$payload['partnerCode'],
            'redirectUrl='.$payload['redirectUrl'],
            'requestId='.$payload['requestId'],
            'requestType='.$payload['requestType'],
        ]);

        return hash_hmac('sha256', $rawSignature, (string) config('services.momo.secret_key'));
    }

    protected function signatureForCallback(array $payload): string
    {
        $rawSignature = implode('&', [
            'accessKey='.config('services.momo.access_key'),
            'amount='.($payload['amount'] ?? ''),
            'extraData='.($payload['extraData'] ?? ''),
            'message='.($payload['message'] ?? ''),
            'orderId='.($payload['orderId'] ?? ''),
            'orderInfo='.($payload['orderInfo'] ?? ''),
            'orderType='.($payload['orderType'] ?? ''),
            'partnerCode='.($payload['partnerCode'] ?? ''),
            'payType='.($payload['payType'] ?? ''),
            'requestId='.($payload['requestId'] ?? ''),
            'responseTime='.($payload['responseTime'] ?? ''),
            'resultCode='.($payload['resultCode'] ?? ''),
            'transId='.($payload['transId'] ?? ''),
        ]);

        return hash_hmac('sha256', $rawSignature, (string) config('services.momo.secret_key'));
    }

    protected function momoAmount(Order $order): int
    {
        $amount = (int) round((float) $order->total_amount);
        $minAmount = (int) config('services.momo.min_amount', 1000);
        $maxAmount = (int) config('services.momo.max_amount', 50000000);

        if ($amount >= $minAmount && $amount <= $maxAmount) {
            return $amount;
        }

        if ((bool) config('services.momo.complete_on_return')) {
            return max($minAmount, min((int) config('services.momo.sandbox_amount', 10000), $maxAmount));
        }

        throw new RuntimeException("So tien MoMo phai nam trong khoang {$minAmount}d - {$maxAmount}d.");
    }

    protected function formatErrorMessage(int $status, array $data, string $body): string
    {
        $message = $data['message'] ?? $body;
        $message = trim((string) $message);

        if ($message === '') {
            return 'MoMo tra ve loi HTTP '.$status.'.';
        }

        return 'MoMo tra ve loi HTTP '.$status.': '.$message;
    }

    protected function buildRequestId(Order $order): string
    {
        return 'MOMO'.$order->id.'T'.now()->format('YmdHis');
    }

    protected function buildMomoOrderId(Order $order): string
    {
        return 'ORDER'.$order->id.'T'.now()->format('YmdHis');
    }
}
