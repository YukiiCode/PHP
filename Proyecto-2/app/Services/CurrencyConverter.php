<?php

namespace App\Services;

use Exception;

class CurrencyConverter
{
    private static $instance = null;
    private $apiKey = null;
    private $apiUrl = 'https://api.exchangerate-api.com/v4/latest/EUR';
    private $rates = [];
    private $lastFetched = null;
    private $cacheDuration = 3600; // Cache duration in seconds (1 hour)

    private function __construct()
    {   
        // You would typically load this from an environment variable
        $this->apiKey = config('services.currency.api_key', null);
        $this->fetchRates();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function fetchRates()
    {
        // If we have rates and they're not expired, use the cached version
        if (!empty($this->rates) && $this->lastFetched && (time() - $this->lastFetched < $this->cacheDuration)) {
            return;
        }

        try {
            $response = file_get_contents($this->apiUrl);
            if ($response === false) {
                throw new Exception('Failed to fetch currency rates');
            }

            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($data['rates'])) {
                throw new Exception('Invalid response from currency API');
            }

            $this->rates = $data['rates'];
            $this->lastFetched = time();
        } catch (Exception $e) {
            if (empty($this->rates)) {
                $this->rates = [
                    'USD' => 1.1, 
                    'GBP' => 0.85,
                    'JPY' => 130,
                ];
            }

        }
    }

    public function convertToEuro($amount, $fromCurrency)
    {
        // Ensure we have the latest rates
        $this->fetchRates();

        // If the currency is already EUR, return the amount
        if ($fromCurrency === 'EUR') {
            return $amount;
        }

        // If we don't have a rate for this currency, return the original amount
        if (!isset($this->rates[$fromCurrency])) {
            return $amount;
        }

        // Convert from the currency to EUR
        // Since our base is EUR, we divide by the rate
        return $amount / $this->rates[$fromCurrency];
    }

    public function convertFromEuro($amount, $toCurrency)
    {
        // Ensure we have the latest rates
        $this->fetchRates();

        // If the currency is already EUR, return the amount
        if ($toCurrency === 'EUR') {
            return $amount;
        }

        // If we don't have a rate for this currency, return the original amount
        if (!isset($this->rates[$toCurrency])) {
            return $amount;
        }

        // Convert from EUR to the target currency
        return $amount * $this->rates[$toCurrency];
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing of the instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}