<?php

namespace App\Services\API\PlaceToPay;

use Illuminate\Support\Facades\Http;

class PlacetopayService
{
    public $baseUrl;

    public $seed;

    public $nonce;

    public $secretKey;

    public $nonceBase64;

    public $tranKey;

    public $authArray;

    public $deadLineDate;

    public $returnUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://dev.placetopay.com/redirection';
        $this->seed = date('c');
        if (function_exists('random_bytes')) {
            $this->nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $this->nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $this->nonce = mt_rand();
        }
        $this->secretKey = config('placetopay.secret_key');
        $this->nonceBase64 = base64_encode($this->nonce);
        $this->tranKey = base64_encode(sha1($this->nonce.$this->seed.$this->secretKey, true));
        $this->authArray = [
            'auth' => [
                'login' => config('placetopay.login'),
                'tranKey' => $this->tranKey,
                'nonce' => $this->nonceBase64,
                'seed' => $this->seed,
            ],
        ];
        $this->deadLineDate = date('c', strtotime(' + 10 minutes'));
        $this->returnUrl = 'http://evertec.test/orders/callback/success';
    }

    public function createSession(
        $reference,
        $description,
        $currency,
        $amount)
    {
        $data = [
            'locale' => 'es_CO',
            'auth' => $this->authArray['auth'],
            'payment' => [
                'reference' => $reference,
                'description' => $description,
                'amount' => [
                    'currency' => $currency,
                    'total' => $amount,
                ],
            ],
            'expiration' => $this->deadLineDate,
            'returnUrl' => "{$this->returnUrl}/{$reference}",
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'PlacetoPay Sandbox',
            'skipResult' => true,
        ];
        $response = Http::post("{$this->baseUrl}/api/session", $data);

        return $response->json();
    }

    public function checkSession($requestId)
    {
        $response = Http::post("{$this->baseUrl}/api/session/{$requestId}", [
            'auth' => $this->authArray['auth'],
        ]);

        return $response->json();
    }
}
