<?php
// database/seeders/WhatsAppTemplateSeeder.php

namespace Database\Seeders;

use App\Models\WhatsAppTemplate;
use Illuminate\Database\Seeder;

class WhatsAppTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name' => 'Attendance Update',
                'category' => 'ATTENDANCE',
                'template_name' => 'attendance_update',
                'body' => 'Hello {{1}}, your attendance for {{2}} has been marked as {{3}}. Remarks: {{4}}',
                'variables' => ['student_name', 'date', 'status', 'remarks']
            ],
            [
                'name' => 'Fee Reminder',
                'category' => 'FEE',
                'template_name' => 'fee_reminder', 
                'body' => 'Hello {{1}}, fee payment reminder. Amount: {{2}}, Due Date: {{3}}, Invoice: {{4}}',
                'variables' => ['student_name', 'amount', 'due_date', 'invoice_number']
            ],
            [
                'name' => 'Exam Result',
                'category' => 'ACADEMIC',
                'template_name' => 'exam_result',
                'body' => 'Hello {{1}}, result for {{2}}: Marks: {{3}}, Percentage: {{4}}, Grade: {{5}}',
                'variables' => ['student_name', 'exam_name', 'marks', 'percentage', 'grade']
            ],
            [
                'name' => 'School Announcement',
                'category' => 'GENERAL',
                'template_name' => 'school_announcement',
                'body' => 'Hello {{1}}, Announcement: {{2}}. Details: {{3}}. Date: {{4}}',
                'variables' => ['student_name', 'title', 'message', 'date']
            ]
        ];

        foreach ($templates as $template) {
            WhatsAppTemplate::create($template);
        }
    }
}