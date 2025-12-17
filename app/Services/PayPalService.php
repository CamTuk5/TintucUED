<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayPalService
{
    private $clientId;
    private $secret;
    private $baseUrl;

    public function __construct()
    {
        $this->clientId = env('PAYPAL_CLIENT_ID');
        $this->secret = env('PAYPAL_SECRET');
        $this->baseUrl = env('PAYPAL_MODE') === 'sandbox' 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';
    }

    private function getAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->secret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        return null;
    }

    
    public function createOrder($amountUSD)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return null;

        $response = Http::withToken($accessToken)->post("{$this->baseUrl}/v2/checkout/orders", [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($amountUSD, 2, '.', '')
                ],
                'description' => 'Nang cap tai khoan VIP TintucAED'
            ]],
            'application_context' => [
                'return_url' => route('subscription.success'), 
                'cancel_url' => route('subscription.index'),
                'brand_name' => 'TintucAED Premium',
                'user_action' => 'PAY_NOW'
            ]
        ]);

        if ($response->successful()) {
            // Lấy link thanh toán
            foreach ($response->json()['links'] as $link) {
                if ($link['rel'] === 'approve') return $link['href'];
            }
        }

        return null;
    }

    // Xác nhận thanh toán
    public function captureOrder($token)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return false;

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders/{$token}/capture", [
                'headers' => ['Content-Type' => 'application/json']
            ]);

        if ($response->successful() && $response->json()['status'] === 'COMPLETED') {
            return true;
        }

        return false;
    }
}