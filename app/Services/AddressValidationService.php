<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AddressValidationService
{
    private string $apiToken;

    public function __construct()
    {
        $this->apiToken = $this->loginAndGetToken();
    }

    /**
     * Login to the external API and return Bearer token
     */
    private function loginAndGetToken(): string
    {
        $email = config('services.asmorphic.email');
        $password = config('services.asmorphic.password');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post('https://extranet.asmorphic.com/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        Log::info('Login API Response: '.$response->body());

        if (! $response->successful()) {
            throw new \Exception('API login failed.');
        }

        return $response->json('result.token');
    }

    /**
     * Parse full address into components
     */
    public function parseAddress(string $address): array
    {
        Log::info('Raw address: '.$address);

        $components = array_map('trim', explode(',', $address));

        if (count($components) < 5) {
            throw new \Exception('Address format is invalid. Expected at least 5 parts.');
        }

        $street_number = $components[0] ?? '';
        $street_name = $components[1] ?? '';
        $suburb = $components[2] ?? '';
        $state_postcode = $components[3] ?? ''; // e.g., VIC 3140
        $country = $components[4] ?? '';

        // Split state and postcode
        $state = '';
        $postcode = '';
        if (preg_match('/([A-Z]{2,3})\s+(\d{4})/i', $state_postcode, $matches)) {
            $state = strtoupper($matches[1]);
            $postcode = $matches[2];
        }

        $parsed = [
            'street_number' => $street_number,
            'street_name' => $street_name,
            'suburb' => $suburb,
            'postcode' => $postcode,
            'state' => $state,
            'country' => $country,
        ];

        Log::info('Parsed address: '.json_encode($parsed, JSON_PRETTY_PRINT));

        return $parsed;
    }

    /**
     * Validate parsed address against external API
     */
    public function validateAddress(array $components): bool
    {
        $payload = [
            'company_id' => 17,
            'street_number' => $components['street_number'] ?? '',
            'street_name' => $components['street_name'] ?? '',
            'suburb' => $components['suburb'] ?? '',
            'postcode' => $components['postcode'] ?? '',
            'state' => $components['state'] ?? '',
        ];

        Log::info('Sending validation payload: '.json_encode($payload));

        $response = Http::withToken($this->apiToken)
            ->post('https://extranet.asmorphic.com/api/orders/findaddress', $payload);

        if (! $response->successful()) {
            Log::error('Address validation failed: '.$response->body());

            return false;
        }

        $data = $response->json();

        if (isset($data[0]['DirectoryIdentifier'])) {
            Log::info('Address validated successfully.');

            return true;
        }

        Log::error('Address not found.');

        return false;
    }
}
