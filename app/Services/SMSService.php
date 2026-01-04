<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMSService
{
    private $baseURL = 'http://nimbusit.net/api/pushsms';
    private $user;
    private $authkey;
    private $sender;

    public function __construct()
    {
        $this->user = config('services.sms.user', 'apkwebtechnet');
        $this->authkey = config('services.sms.authkey', '92Pax0moI7wgE');
        $this->sender = config('services.sms.sender', 'APKCOM');
    }

    /**
     * Send SMS to a single number
     */
    public function sendSMS(string $mobile, string $message): array
    {
        try {
            $formattedMobile = $this->formatMobileNumber($mobile);
            
            $params = [
                'user' => $this->user,
                'authkey' => $this->authkey,
                'sender' => $this->sender,
                'mobile' => $formattedMobile,
                'text' => $message
            ];

            Log::info('SMS API Request', [
                'api_url' => $this->baseURL,
                'params' => $params,
                'full_url' => $this->baseURL . '?' . http_build_query($params)
            ]);

            $response = Http::timeout(30)->get($this->baseURL, $params);
            
            Log::info('SMS API Response', [
                'mobile' => $formattedMobile,
                'message' => $message,
                'response_body' => $response->body(),
                'response_status' => $response->status()
            ]);

            if ($response->successful()) {
                $responseData = $response->body();
                
                // Parse response - NimbusIT usually returns simple responses
                $isSuccess = $this->parseResponse($responseData);
                
                if ($isSuccess) {
                    return [
                        'success' => true,
                        'data' => $responseData,
                        'message' => 'SMS sent successfully'
                    ];
                } else {
                    return [
                        'success' => false,
                        'error' => 'SMS sending failed',
                        'response' => $responseData
                    ];
                }
            }

            return [
                'success' => false,
                'error' => 'API request failed with status: ' . $response->status(),
                'response_body' => $response->body(),
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('SMS API Exception', [
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
     * Send bulk SMS to multiple numbers
     */
    public function sendBulkSMS(array $numbers, string $message): array
    {
        $results = [];
        
        foreach ($numbers as $index => $number) {
            $result = $this->sendSMS($number, $message);
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
        
        $successful = count(array_filter($results, fn($r) => $r['success']));
        
        Log::info('Bulk SMS Summary', [
            'total_numbers' => count($numbers),
            'successful' => $successful,
            'failed' => count($numbers) - $successful
        ]);
        
        return [
            'success' => $successful > 0,
            'data' => $results,
            'summary' => [
                'total' => count($numbers),
                'successful' => $successful,
                'failed' => count($numbers) - $successful
            ],
            'message' => "Sent {$successful} SMS successfully out of " . count($numbers)
        ];
    }

    /**
     * Send SMS to student's contacts
     */
    public function sendToStudent($student, $message, $sendTo = 'all'): array
    {
        $numbers = $this->getStudentMobileNumbers($student, $sendTo);
        
        if (empty($numbers)) {
            return [
                'success' => false,
                'error' => 'No valid mobile numbers found for the student'
            ];
        }

        $results = $this->sendBulkSMS($numbers, $message);

        return [
            'success' => $results['success'],
            'data' => $results['data'],
            'message' => "Sent SMS to " . $results['summary']['successful'] . " contact(s) of {$student->full_name}"
        ];
    }

    /**
     * Send SMS to entire class
     */
    public function sendToClass($students, $message, $sendTo = 'all'): array
    {
        $allNumbers = [];
        
        foreach ($students as $student) {
            $numbers = $this->getStudentMobileNumbers($student, $sendTo);
            $allNumbers = array_merge($allNumbers, $numbers);
        }

        $allNumbers = array_unique($allNumbers); // Remove duplicates

        if (empty($allNumbers)) {
            return [
                'success' => false,
                'error' => 'No valid mobile numbers found for the class'
            ];
        }

        $results = $this->sendBulkSMS($allNumbers, $message);

        return [
            'success' => $results['success'],
            'data' => $results['data'],
            'summary' => [
                'total_students' => $students->count(),
                'total_numbers' => count($allNumbers),
                'successful' => $results['summary']['successful'],
                'failed' => $results['summary']['failed']
            ],
            'message' => "Sent SMS to " . $results['summary']['successful'] . " contact(s) of {$students->count()} students"
        ];
    }

    /**
     * Get student mobile numbers based on send_to option
     */
    private function getStudentMobileNumbers($student, $sendTo): array
    {
        $numbers = [];
        
        // Father's contact
        if (($sendTo === 'father' || $sendTo === 'all') && !empty($student->father_contact)) {
            $numbers[] = $student->father_contact;
        }
        
        // Mother's contact
        if (($sendTo === 'mother' || $sendTo === 'all') && !empty($student->mother_contact)) {
            $numbers[] = $student->mother_contact;
        }
        
        // Guardian's contact
        if (($sendTo === 'guardian' || $sendTo === 'all') && !empty($student->guardian_contact)) {
            $numbers[] = $student->guardian_contact;
        }
        
        // Student's mobile
        if (($sendTo === 'student' || $sendTo === 'all') && !empty($student->mobile_no)) {
            $numbers[] = $student->mobile_no;
        }

        return array_filter($numbers); // Remove empty values
    }

    /**
     * Format mobile number (remove spaces, etc.)
     */
    private function formatMobileNumber(string $mobile): string
    {
        // Remove any spaces, dashes, or plus signs
        $mobile = preg_replace('/[+\s\-]/', '', $mobile);
        
        return $mobile;
    }

    /**
     * Parse NimbusIT API response
     */
    private function parseResponse(string $response): bool
    {
        // NimbusIT typically returns simple responses
        // You might need to adjust this based on their actual response format
        if (strpos($response, 'success') !== false || strpos($response, '200') !== false) {
            return true;
        }
        
        if (strpos($response, 'error') !== false || strpos($response, 'failed') !== false) {
            return false;
        }
        
        // If we can't determine, assume success for non-error responses
        return true;
    }

    /**
     * Test SMS configuration
     */
    public function testConnection(): array
    {
        $testNumber = '9555019146'; // Your test number from the example
        $testMessage = 'Test SMS from School Management System - ' . date('Y-m-d H:i:s');
        
        return $this->sendSMS($testNumber, $testMessage);
    }

    /**
     * Check SMS balance (if supported by API)
     */
    public function checkBalance(): array
    {
        try {
            // This endpoint might be different - check NimbusIT documentation
            $response = Http::get('http://nimbusit.net/api/balance', [
                'user' => $this->user,
                'authkey' => $this->authkey
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'balance' => $response->body()
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to check balance'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}