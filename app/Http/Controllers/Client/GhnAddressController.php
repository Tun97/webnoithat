<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GhnAddressController extends Controller
{
    /**
     * Return the province list from GHN.
     */
    public function provinces(): JsonResponse
    {
        return response()->json([
            'data' => $this->requestGhn('GET', '/master-data/province'),
        ]);
    }

    /**
     * Return districts by province id.
     */
    public function districts(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'province_id' => ['required', 'integer'],
        ]);

        return response()->json([
            'data' => $this->requestGhn('GET', '/master-data/district', [
                'province_id' => (int) $validated['province_id'],
            ]),
        ]);
    }

    /**
     * Return wards by district id.
     */
    public function wards(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'district_id' => ['required', 'integer'],
        ]);

        return response()->json([
            'data' => $this->requestGhn('POST', '/master-data/ward', [
                'district_id' => (int) $validated['district_id'],
            ]),
        ]);
    }

    /**
     * Make a GHN request and normalize the payload.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function requestGhn(string $method, string $uri, array $payload = []): array
    {
        $token = (string) config('services.ghn.token');
        $baseUrl = rtrim((string) config('services.ghn.base_url'), '/');

        abort_if($token === '', 500, 'GHN token chưa được cấu hình.');

        $response = Http::baseUrl($baseUrl)
            ->withHeaders([
                'Token' => $token,
                'Content-Type' => 'application/json',
            ])
            ->acceptJson()
            ->timeout(15)
            ->send($method, $uri, $method === 'GET'
                ? ['query' => $payload]
                : ['json' => $payload]);

        $response->throw();

        if ((int) $response->json('code') !== 200) {
            abort(502, (string) ($response->json('message') ?: 'GHN trả về dữ liệu không hợp lệ.'));
        }

        $data = $response->json('data');

        if (is_array($data) && array_is_list($data)) {
            return $data;
        }

        if (is_array($data) && isset($data[0])) {
            return $data;
        }

        return [];
    }
}
