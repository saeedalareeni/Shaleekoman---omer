<?php

namespace App\Services;

use App\Models\Payment_method;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class ThawaniPaymentService
{
    protected $baseUri;
    protected $publishApiKey;
    protected $secretApiKey;
    protected $payBaseUrl;

    public function __construct()
    {
        $setting = Setting::first();

        $mode = $setting->thawani_mode ?? env('THAWANI_MODE', 'test');
        $isLive = $mode === 'live';

        $apiHost = $isLive ? 'https://checkout.thawani.om' : 'https://uatcheckout.thawani.om';
        $this->baseUri = $apiHost . '/api/v1/checkout/session';
        $this->payBaseUrl = $apiHost . '/pay/';

        // Prefer keys from settings, fallback to Payment_method, then env
        $paymentMethod = Payment_method::where('name_en', 'Card payment')->first();

        $this->publishApiKey =
            $setting->thawani_publishable_key
            ?? ($paymentMethod->publish_key ?? null)
            ?? env('THAWANI_PUBLISH_API_KEY');

        $this->secretApiKey =
            $setting->thawani_secret_key
            ?? ($paymentMethod->secret_key ?? null)
            ?? env('THAWANI_API_SECRET_KEY');
    }

    public function pay($orderNumber, $products, $customerName, $customerEmail, $customerContact)
    {
        if (!$this->publishApiKey || !$this->secretApiKey) {
            throw new \RuntimeException('Thawani keys are missing (publish/secret).');
        }

        $successUrl = route('payments_success',  $orderNumber);
        $cancelUrl = route('payments_cancel',  $orderNumber);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'thawani-api-key' => $this->secretApiKey,
        ])->post($this->baseUri, [
            'client_reference_id' => $orderNumber,
            'customer_id' => '',
            'products' => json_decode($products, true),
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'customerName' => $customerName,
                'customerEmail' => $customerEmail,
                'customerContact' => $customerContact,
                'OrderID' => $orderNumber,
            ],
        ]);
        if ($response->successful() && isset($response['data'])) {
            $sessionId = $response['data']['session_id'];
            return $this->payBaseUrl . $sessionId . '?key=' . $this->publishApiKey;
        }

        throw new \RuntimeException('Thawani session create failed: ' . $response->status() . ' ' . $response->body());
    }

    public function getSingleSession($sessionId)
    {
        $response = Http::withHeaders([
            'thawani-api-key' => $this->secretApiKey,
        ])->get($this->baseUri . '/' . $sessionId);

        return $response->body();
    }

    public function getAllSessions()
    {
        $response = Http::withHeaders([
            'thawani-api-key' => $this->secretApiKey,
        ])->get($this->baseUri, [
            'limit' => 5,
            'skip' => 1,
        ]);

        return $response->body();
    }
}
