<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsappService
{
    // 🔥 SAME URL AS CURL
    protected $apiUrl = 'https://msggo.in/api/create-message';

    /**
     * Send WhatsApp Text Message
     */
  public function sendText($contact, $message)
{
    $appKey  = setting('whatsapp_app_key');
    $authKey = setting('whatsapp_auth_key');

    if (!$appKey || !$authKey) {
        throw new \Exception('WhatsApp API keys missing');
    }
    Log::info('WhatsApp Keys', [
    'appkey' => $appKey,
    'authkey' => $authKey,
]);


    $contact = preg_replace('/\D/', '', $contact);

    Log::info('WhatsApp API Hit', [
        'to' => $contact,
        'message' => $message
    ]);

    $postData = http_build_query([
        'appkey'  => $appKey,
        'authkey' => $authKey,
        'to'      => $contact,
        'message' => $message,
        'sandbox' => 'false',
    ]);

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL            => $this->apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $postData,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/x-www-form-urlencoded',
        ],
        CURLOPT_TIMEOUT        => 30,
    ]);

    $response   = curl_exec($curl);
    $httpCode   = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError  = curl_error($curl);

    curl_close($curl);

    if ($curlError) {
        throw new \Exception($curlError);
    }

    Log::info('WhatsApp Raw Response', [
        'http_code' => $httpCode,
        'response'  => $response
    ]);

    $decoded = json_decode($response, true);

    if (!is_array($decoded)) {
        throw new \Exception('Invalid WhatsApp API response');
    }

    // 🔥 IMPORTANT FIX
    if (isset($decoded['error'])) {
        throw new \Exception($decoded['error']);
    }

    if ($httpCode !== 200) {
        throw new \Exception('WhatsApp API HTTP Error ' . $httpCode);
    }

    return true; // ✅ SENT
}

}
