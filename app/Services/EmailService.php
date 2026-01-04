<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send single email
     */
    public function sendEmail($to, $subject, $message, $cc = [], $bcc = [], $attachments = []): array
    {
        try {
            $data = [
                'subject' => $subject,
                'content' => $message,
                'schoolName' => config('app.name')
            ];

            // Send email using try-catch for better error handling
            Mail::send('emails.template', $data, function ($mail) use ($to, $subject, $cc, $bcc, $attachments) {
                $mail->to($to)
                     ->subject($subject);
                
                // Add CC recipients
                if (!empty($cc)) {
                    foreach ($cc as $ccEmail) {
                        $mail->cc($ccEmail);
                    }
                }
                
                // Add BCC recipients
                if (!empty($bcc)) {
                    foreach ($bcc as $bccEmail) {
                        $mail->bcc($bccEmail);
                    }
                }
                
                // Add attachments
                if (!empty($attachments)) {
                    foreach ($attachments as $attachment) {
                        $mail->attach($attachment['path'], [
                            'as' => $attachment['name'] ?? basename($attachment['path']),
                            'mime' => $attachment['mime'] ?? null,
                        ]);
                    }
                }
            });

            Log::info('Email sent successfully', [
                'to' => $to,
                'subject' => $subject,
                'cc' => $cc,
                'bcc' => $bcc
            ]);

            return [
                'success' => true,
                'message' => 'Email sent successfully'
            ];

        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'to' => $to,
                'subject' => $subject,
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
     * Send bulk emails
     */
    public function sendBulkEmails($recipients, $subject, $message, $attachments = []): array
    {
        $results = [];
        $successCount = 0;
        $failCount = 0;
        
        foreach ($recipients as $recipient) {
            $result = $this->sendEmail($recipient, $subject, $message, [], [], $attachments);
            $results[] = [
                'email' => $recipient,
                'success' => $result['success'],
                'error' => $result['error'] ?? null
            ];
            
            if ($result['success']) {
                $successCount++;
            } else {
                $failCount++;
            }
            
            // Small delay to avoid rate limiting
            usleep(100000); // 0.1 seconds
        }

        Log::info('Bulk email sending completed', [
            'total' => count($recipients),
            'successful' => $successCount,
            'failed' => $failCount
        ]);

        return [
            'success' => $successCount > 0,
            'data' => $results,
            'summary' => [
                'total' => count($recipients),
                'successful' => $successCount,
                'failed' => $failCount
            ],
            'message' => "Sent {$successCount} emails successfully out of " . count($recipients)
        ];
    }

    /**
     * Send email to student's contacts
     */
    public function sendToStudent($student, $subject, $message, $sendTo = 'all', $attachments = []): array
    {
        $emails = $this->getStudentEmails($student, $sendTo);
        
        if (empty($emails)) {
            return [
                'success' => false,
                'error' => 'No valid email addresses found for the student'
            ];
        }

        $results = $this->sendBulkEmails($emails, $subject, $message, $attachments);

        return [
            'success' => $results['success'],
            'data' => $results['data'],
            'message' => "Sent email to " . $results['summary']['successful'] . " contact(s) of {$student->full_name}"
        ];
    }

    /**
     * Send email to entire class
     */
    public function sendToClass($students, $subject, $message, $sendTo = 'all', $attachments = []): array
    {
        $allEmails = [];
        
        foreach ($students as $student) {
            $emails = $this->getStudentEmails($student, $sendTo);
            $allEmails = array_merge($allEmails, $emails);
        }

        $allEmails = array_unique($allEmails); // Remove duplicates

        if (empty($allEmails)) {
            return [
                'success' => false,
                'error' => 'No valid email addresses found for the class'
            ];
        }

        $results = $this->sendBulkEmails($allEmails, $subject, $message, $attachments);

        return [
            'success' => $results['success'],
            'data' => $results['data'],
            'summary' => [
                'total_students' => $students->count(),
                'total_emails' => count($allEmails),
                'successful' => $results['summary']['successful'],
                'failed' => $results['summary']['failed']
            ],
            'message' => "Sent email to " . $results['summary']['successful'] . " contact(s) of {$students->count()} students"
        ];
    }

    /**
     * Get student email addresses based on send_to option
     */
    private function getStudentEmails($student, $sendTo): array
    {
        $emails = [];
        
        // Father's email
        if (($sendTo === 'father' || $sendTo === 'all') && !empty($student->father_email)) {
            $emails[] = $student->father_email;
        }
        
        // Mother's email
        if (($sendTo === 'mother' || $sendTo === 'all') && !empty($student->mother_email)) {
            $emails[] = $student->mother_email;
        }
        
        // Guardian's email
        if (($sendTo === 'guardian' || $sendTo === 'all') && !empty($student->guardian_email)) {
            $emails[] = $student->guardian_email;
        }
        
        // Student's email
        if (($sendTo === 'student' || $sendTo === 'all') && !empty($student->email)) {
            $emails[] = $student->email;
        }

        return array_filter($emails); // Remove empty values
    }

    /**
     * Test email configuration
     */
    public function testEmail($to = null): array
    {
        $testEmail = $to ?? config('mail.from.address');
        
        // Check if test email is valid
        if (empty($testEmail) || !filter_var($testEmail, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'error' => 'Invalid test email address'
            ];
        }

        $subject = 'Test Email from ' . config('app.name');
        $message = 'This is a test email to verify your email configuration is working correctly.' . "\n\n" .
                  'If you received this email, your SMTP configuration is working properly.' . "\n\n" .
                  'Timestamp: ' . now()->format('Y-m-d H:i:s');

        return $this->sendEmail($testEmail, $subject, $message);
    }

    /**
     * Simple email sending without template (for debugging)
     */
    public function sendRawEmail($to, $subject, $message): array
    {
        try {
            Mail::raw($message, function ($mail) use ($to, $subject) {
                $mail->to($to)
                     ->subject($subject);
            });

            Log::info('Raw email sent successfully', [
                'to' => $to,
                'subject' => $subject
            ]);

            return [
                'success' => true,
                'message' => 'Raw email sent successfully'
            ];

        } catch (\Exception $e) {
            Log::error('Raw email sending failed', [
                'to' => $to,
                'subject' => $subject,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}