<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TapService
{
    protected $baseUrl = 'https://api.tap.company/v2/';
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.tap.secret');
    }

    public function createCharge($name,$amount, $currency, $description, $phone, $source)
    {
        $response = Http::withToken($this->secretKey)->post($this->baseUrl . 'charges', [
            'amount' => $amount,
            'currency' => $currency,
            'description' => $description,
            'customer' => [
                "first_name"=> $name ,
                "phone" => [
                            "country_code" => 966,
                            "number" => $phone
                ], 
            ],
            'source' => [
                'id' =>  $source,
            ],
            'redirect' => [
                'url' => route('student.tap.callback'),
            ],
        ]);

        return $response->json();
    }



    public function findCharge($tapId)
    {
        try {
            $url = "https://api.tap.company/v2/charges/{$tapId}";

            $response = Http::withToken($this->secretKey)
                ->acceptJson()
                ->get($url);

            if ($response->failed()) {
                throw new Exception('Tap API request failed: ' . $response->body());
            }

            return $response->json();

        } catch (Exception $e) {
            throw new Exception('Error fetching charge info: ' . $e->getMessage());
        }
    }
}
