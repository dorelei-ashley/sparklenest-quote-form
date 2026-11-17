<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot: bots fill this hidden field, humans don't
        if ($request->filled('website')) {
            return redirect()->route('quote.thanks');
        }

        $data = $request->validate([
            'first_name'     => 'required|string|max:80',
            'last_name'      => 'required|string|max:80',
            'phone'          => 'required|string|max:30',
            'email'          => 'required|email|max:120',
            'service_type'   => 'required|in:Standard Clean,Deep Clean,Move-In/Move-Out',
            'bedrooms'       => 'required|string|max:5',
            'bathrooms'      => 'required|string|max:5',
            'zip_code'       => 'required|digits:5',
            'preferred_date' => 'required|date|after_or_equal:today',
            'consent'        => 'accepted',
        ]);

        $payload = [
            'first_name'     => $data['first_name'],
            'last_name'      => $data['last_name'],
            'phone'          => $data['phone'],
            'email'          => $data['email'],
            'service_type'   => $data['service_type'],
            'bedrooms'       => $data['bedrooms'],
            'bathrooms'      => $data['bathrooms'],
            'zip_code'       => $data['zip_code'],
            'preferred_date' => $data['preferred_date'],
            'sms_consent'    => true,
            'source'         => 'laravel-portfolio-site',
            'submitted_at'   => now()->toIso8601String(),
        ];

        Log::info('Quote payload', $payload);

        $url = config('services.ghl.webhook_url');

        if ($url) {
            try {
                $response = Http::timeout(10)->acceptJson()->post($url, $payload);

                if ($response->failed()) {
                    Log::warning('Webhook failed', ['status' => $response->status()]);
                }
            } catch (\Throwable $e) {
                Log::error('Webhook error: ' . $e->getMessage());
            }
        }

        return redirect()->route('quote.thanks')->with('first_name', $data['first_name']);
    }
}