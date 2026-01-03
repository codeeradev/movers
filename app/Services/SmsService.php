<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    private $baseUrl = "https://bulksmsplans.com/api/send_sms";
    private $apiId = "APIR1yhG7VS146940";
    private $apiPassword = '$2y$10$GfA6nekPYc1fALj04E304eAmXxA1AKUzg8vxYPzW.dEcA.hFpqFD2';
    private $sender = "RAJPDR";

    public function send($number, $message, $templateId = null)
    {
        $response = Http::get($this->baseUrl, [
            'api_id'        => $this->apiId,
            'api_password'  => $this->apiPassword,
            'sms_type'      => 'Transactional',
            'sms_encoding'  => 'text',
            'sender'        => $this->sender,
            'number'        => $number,
            'message'       => $message,
            'template_id'   => $templateId,
        ]);

        return $response->json();
    }
}
