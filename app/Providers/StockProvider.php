<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class StockProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $apiKey = config('services.alphavantage.key'); // API-key ophalen
        $stockData = Cache::remember('stock_data', now()->addMinutes(10), function () use ($apiKey) {
            return [
                'eur_usd' => $this->getStockData('EURUSD', $apiKey),
                'btc_usd' => $this->getStockData('BTCUSD', $apiKey),
                'eth_usd' => $this->getStockData('ETHUSD', $apiKey),
            ];
        });

        View::share('stockData', $stockData);
    }

    private function getStockData($symbol, $apiKey)
    {
        $url = 'https://www.alphavantage.co/query';
        $response = Http::withoutVerifying()->get($url, [
            'function' => 'GLOBAL_QUOTE',
            'symbol' => $symbol,
            'apikey' => $apiKey,
        ]);

        $data = $response->json()['Global Quote'] ?? [];

        // Debugging log om API-respons te controleren
        Log::info("Stock API Response voor {$symbol}:", $data);

        // Als de API geen geldige data terugstuurt, log en geef een lege array terug
        if (! is_array($data) || empty($data)) {
            Log::error("Fout bij ophalen van {$symbol}", ['response' => $response->json()]);

            return [
                'price' => 'N/A',
                'change' => 'N/A',
                'change_percent' => 'N/A',
            ];
        }

        return [
            'price' => $data['05. price'] ?? 'N/A',
            'change' => $data['09. change'] ?? 'N/A',
            'change_percent' => $data['10. change percent'] ?? 'N/A',
        ];
    }
}
