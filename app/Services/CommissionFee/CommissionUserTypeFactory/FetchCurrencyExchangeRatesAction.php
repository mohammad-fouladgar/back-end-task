<?php

namespace App\Services\CommissionFee\CommissionUserTypeFactory;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class FetchCurrencyExchangeRatesAction
{
//    public function curlExecute()
//    {
//        $curlHandle = curl_init();
//
//        curl_setopt(
//            $curlHandle,
//            CURLOPT_URL,
//            'https://developers.paysera.com/tasks/api/currency-exchange-rates'
//        );
//        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
//
//        $currencyRates = curl_exec($curlHandle);
//        curl_close($curlHandle);
//
//        return json_decode($currencyRates, true)['rates'];
//    }

    /**
     * @throws RequestException
     */
    public function execute()
    {
        $response = Http::retry(3, 100)->get('https://developers.paysera.com/tasks/api/currency-exchange-rates');

        if (!$response->successful()) {
            $response->throw();
        }

        return $response->json('rates');
    }
}
