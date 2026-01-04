<?php
// app/Console/Commands/TestWhatsAppConnection.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class TestWhatsAppConnection extends Command
{
    protected $signature = 'whatsapp:test';
    protected $description = 'Test WhatsApp API connection';

    public function handle()
    {
        $whatsapp = new WhatsAppService();
        
        try {
            // Test with a simple message
            $response = $whatsapp->sendTemplateMessage(
                '919876543210', // Test phone number with country code
                'hello_world',  // Use a simple template
                ['Test User']
            );
            
            if (isset($response['error'])) {
                $this->error('Connection failed: ' . $response['error']);
            } else {
                $this->info('✅ Connection successful!');
                $this->info('Response: ' . json_encode($response));
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Connection failed: ' . $e->getMessage());
            $this->info('Please check your .env configuration');
        }
    }
}