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
    private $cacheDuration = 3600; // Duración de la caché en segundos (1 hora)

    private function __construct()
    {   
        // Normalmente cargarías esto desde una variable de entorno
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
        // Si tenemos tasas y no han expirado, usar la versión en caché
        if (!empty($this->rates) && $this->lastFetched && (time() - $this->lastFetched < $this->cacheDuration)) {
            return;
        }

        try {
            $response = file_get_contents($this->apiUrl);
            if ($response === false) {
                throw new Exception('Error al obtener tasas de cambio');
            }

            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($data['rates'])) {
                throw new Exception('Respuesta inválida de la API de divisas');
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
        // Asegurar que tenemos las tasas más recientes
        $this->fetchRates();

        // Si la moneda ya es EUR, devolver el monto
        if ($fromCurrency === 'EUR') {
            return $amount;
        }

        // Si no tenemos una tasa para esta moneda, devolver el monto original
        if (!isset($this->rates[$fromCurrency])) {
            return $amount;
        }

        // Convertir de la moneda a EUR
        // Como nuestra base es EUR, dividimos por la tasa
        return $amount / $this->rates[$fromCurrency];
    }

    public function convertFromEuro($amount, $toCurrency)
    {
        // Asegurar que tenemos las tasas más recientes
        $this->fetchRates();

        // Si la moneda ya es EUR, devolver el monto
        if ($toCurrency === 'EUR') {
            return $amount;
        }

        // Si no tenemos una tasa para esta moneda, devolver el monto original
        if (!isset($this->rates[$toCurrency])) {
            return $amount;
        }

        // Convertir de EUR a la moneda objetivo
        return $amount * $this->rates[$toCurrency];
    }

    // Prevenir la clonación de la instancia
    private function __clone() {}

    // Prevenir la deserialización de la instancia
    public function __wakeup() {
        throw new Exception("No se puede deserializar el singleton");
    }
}