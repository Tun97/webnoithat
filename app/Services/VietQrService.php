<?php

namespace App\Services;

use App\Models\Order;

class VietQrService
{
    public function forOrder(Order $order): ?array
    {
        if ($order->payment_method !== 'bank_transfer') {
            return null;
        }

        $bank = trim((string) config('services.vietqr.bank'));
        $account = trim((string) config('services.vietqr.account'));

        if ($bank === '' || $account === '') {
            return null;
        }

        $amount = (int) round((float) $order->total_amount);
        $content = $this->transferContent($order);
        $template = config('services.vietqr.template', 'compact2');

        return [
            'bank' => $bank,
            'account' => $account,
            'account_name' => trim((string) config('services.vietqr.account_name')),
            'amount' => $amount,
            'content' => $content,
            'qr_url' => sprintf(
                'https://img.vietqr.io/image/%s-%s-%s.png?amount=%d&addInfo=%s',
                rawurlencode($bank),
                rawurlencode($account),
                rawurlencode($template),
                $amount,
                rawurlencode($content)
            ),
        ];
    }

    protected function transferContent(Order $order): string
    {
        $prefix = (string) config('services.vietqr.add_info_prefix', 'ORDER');
        $content = $prefix.$order->id;

        return preg_replace('/[^A-Za-z0-9]/', '', $content) ?: 'ORDER'.$order->id;
    }
}
