<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private $apiKey;
    private $baseURL = 'http://wapi.iconicsolution.co.in/wapp/v2/api/send';

    public function __construct()
    {
        $this->apiKey = config('services.whatsapp.api_key', '9ca9d49f2f56422b8ecc13b5e533f1f6');
    }

    /**
     * Send WhatsApp message to a single number
     */
    public function sendMessage(string $mobile, string $message): array
    {
        try {
            $formattedMobile = $this->formatMobileNumber($mobile);
            
            $params = [
                'apikey' => $this->apiKey,
                'mobile' => $formattedMobile,
                'msg' => $message
            ];

            Log::info('WhatsApp API Request', [
                'api_url' => $this->baseURL,
                'params' => $params,
                'full_url' => $this->baseURL . '?' . http_build_query($params)
            ]);

            $response = Http::timeout(30)->get($this->baseURL, $params);
            
            Log::info('WhatsApp API Response', [
                'mobile' => $formattedMobile,
                'message' => $message,
                'response_body' => $response->body(),
                'response_status' => $response->status(),
                'response_headers' => $response->headers()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                return [
                    'success' => true,
                    'data' => $responseData,
                    'message' => 'WhatsApp message sent successfully'
                ];
            }

            return [
                'success' => false,
                'error' => 'API request failed with status: ' . $response->status(),
                'response_body' => $response->body(),
                'data' => $response->json() ?? null,
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp API Exception', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send bulk messages to multiple numbers
     */
    public function sendBulkMessages(array $numbers, string $message): array
    {
        $results = [];
        
        foreach ($numbers as $index => $number) {
            $result = $this->sendMessage($number, $message);
            $results[] = [
                'number' => $number,
                'success' => $result['success'],
                'response' => $result['data'] ?? null,
                'error' => $result['error'] ?? null
            ];
            
            // Delay to avoid rate limiting (2 seconds between messages)
            if ($index < count($numbers) - 1) {
                sleep(2);
            }
        }
        
        Log::info('Bulk WhatsApp Messages Summary', [
            'total_numbers' => count($numbers),
            'successful' => count(array_filter($results, fn($r) => $r['success'])),
            'failed' => count(array_filter($results, fn($r) => !$r['success']))
        ]);
        
        return $results;
    }

    /**
     * Format mobile number to Indian format (91XXXXXXXXXX)
     */
    private function formatMobileNumber(string $mobile): string
    {
        // Remove any spaces, dashes, or plus signs
        $mobile = preg_replace('/[+\s\-]/', '', $mobile);
        
        // If number starts with 0, replace with 91
        if (substr($mobile, 0, 1) === '0') {
            $mobile = '91' . substr($mobile, 1);
        }
        
        // If number doesn't start with country code, add 91
        if (strlen($mobile) === 10) {
            $mobile = '91' . $mobile;
        }
        
        // Ensure it's exactly 12 digits (91 + 10 digit number)
        if (strlen($mobile) !== 12) {
            Log::warning('Invalid mobile number format', [
                'original' => $mobile,
                'formatted' => $mobile
            ]);
        }
        
        return $mobile;
    }

    /**
     * Test API connection
     */
    public function testConnection(): array
    {
        $testNumber = '919898989898'; // Test number
        $testMessage = 'Test message from Laravel School System';
        
        return $this->sendMessage($testNumber, $testMessage);
    }

    /**
     * Pre-defined message templates for school
     */
    public function getMessageTemplates(): array
    {
        return [
            'attendance' => [
                'present' => 'Dear parent, your child {{student_name}} was present today in school. Attendance Date: {{date}}',
                'absent' => 'Dear parent, your child {{student_name}} was absent today. Please inform the school about the reason. Date: {{date}}'
            ],
            'fee' => [
                'reminder' => 'Dear parent, the school fee of ₹{{amount}} for {{month}} is due. Please pay before {{due_date}}.',
                'paid' => 'Dear parent, fee of ₹{{amount}} for {{month}} has been received. Thank you! Receipt No: {{receipt_no}}'
            ],
            'homework' => 'Homework for {{subject}}: {{homework_details}}. Due date: {{due_date}}',
            'exam' => 'Exam schedule: {{exam_name}} on {{exam_date}}. Venue: {{venue}}. All the best!',
            'ptm' => 'Parent Teacher Meeting scheduled on {{date}} at {{time}}. Please be present.',
            'holiday' => 'School will remain closed on {{date}} for {{reason}}. Happy holidays!'
        ];
    }

    /**
     * Replace placeholders in template
     */
    public function parseTemplate(string $template, array $data): string
    {
        foreach ($data as $key => $value) {
            $template = str_replace("{{{$key}}}", $value, $template);
        }
        return $template;
    }
}