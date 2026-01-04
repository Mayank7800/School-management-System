<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Email Messenger</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center mb-6">
                <i class="fas fa-envelope text-blue-500 text-3xl mr-3"></i>
                <h1 class="text-2xl font-bold text-gray-800">School Email Messenger</h1>
            </div>

            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button id="singleTab" class="tab-button py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" onclick="switchTab('single')">
                        Single Email
                    </button>
                    <button id="studentTab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" onclick="switchTab('student')">
                        Send to Student
                    </button>
                    <button id="classTab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" onclick="switchTab('class')">
                        Send to Class
                    </button>
                    <button id="bulkTab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" onclick="switchTab('bulk')">
                        Bulk Send
                    </button>
                </nav>
            </div>

            <!-- Single Email Tab -->
            <div id="singleTabContent" class="tab-content">
                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address *
                    </label>
                    <input type="email" id="email" name="email" 
                           class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter email address"
                           value="test@example.com">
                </div>

                <!-- Subject Input -->
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">
                        Subject *
                    </label>
                    <input type="text" id="subject" name="subject" 
                           class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter email subject"
                           value="Important Announcement from School">
                </div>

                <!-- Message Input -->
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                        Message *
                    </label>
                    <textarea id="message" name="message" rows="8"
                              class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Type your email message here...">Dear Parent,

This is an important announcement from the school management.

Thank you,
School Administration</textarea>
                </div>

                <!-- CC and BCC -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="cc" class="block text-sm font-medium text-gray-700 mb-1">
                            CC (Optional)
                        </label>
                        <input type="text" id="cc" name="cc" 
                               class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="CC emails (comma separated)">
                    </div>
                    <div>
                        <label for="bcc" class="block text-sm font-medium text-gray-700 mb-1">
                            BCC (Optional)
                        </label>
                        <input type="text" id="bcc" name="bcc" 
                               class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="BCC emails (comma separated)">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button onclick="sendEmail()" 
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>Send Email
                    </button>
                    <button onclick="testEmail()" 
                            class="bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                        <i class="fas fa-vial mr-2"></i>Test
                    </button>
                </div>
            </div>

            <!-- Send to Student Tab -->
            <div id="studentTabContent" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <!-- Student Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Student</label>
                        <select id="studentSelect" class="w-full p-3 border border-gray-300 rounded-md">
                            <option value="">Select a student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" 
                                        data-father-email="{{ $student->father_email ?? '' }}"
                                        data-mother-email="{{ $student->mother_email ?? '' }}"
                                        data-guardian-email="{{ $student->guardian_email ?? '' }}"
                                        data-student-email="{{ $student->email ?? '' }}">
                                    {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }} - {{ $student->admission_no }} - {{ $student->course_name }}{{ $student->section ? ' - ' . $student->section : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Send To Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Send To</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_student" value="father" class="form-radio text-blue-500" checked>
                                <span class="ml-2">Father</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_student" value="mother" class="form-radio text-blue-500">
                                <span class="ml-2">Mother</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_student" value="guardian" class="form-radio text-blue-500">
                                <span class="ml-2">Guardian</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_student" value="student" class="form-radio text-blue-500">
                                <span class="ml-2">Student</span>
                            </label>
                            <label class="inline-flex items-center col-span-2">
                                <input type="radio" name="send_to_student" value="all" class="form-radio text-blue-500">
                                <span class="ml-2">All Contacts</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Student Details -->
                <div id="studentDetails" class="mb-4 p-4 bg-gray-50 rounded-md hidden">
                    <h4 class="font-medium text-gray-700 mb-2">Student Email Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div><span class="font-medium">Admission No:</span> <span id="admissionNo">-</span></div>
                        <div><span class="font-medium">Class:</span> <span id="studentClass">-</span></div>
                        <div><span class="font-medium">Father Email:</span> <span id="fatherEmail">-</span></div>
                        <div><span class="font-medium">Mother Email:</span> <span id="motherEmail">-</span></div>
                        <div><span class="font-medium">Guardian Email:</span> <span id="guardianEmail">-</span></div>
                        <div><span class="font-medium">Student Email:</span> <span id="studentEmail">-</span></div>
                    </div>
                </div>

                <!-- Subject Input -->
                <div class="mb-4">
                    <label for="studentSubject" class="block text-sm font-medium text-gray-700 mb-1">
                        Subject *
                    </label>
                    <input type="text" id="studentSubject" name="studentSubject" 
                           class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter email subject"
                           value="Regarding your child - {{ date('d/m/Y') }}">
                </div>

                <!-- Message Input -->
                <div class="mb-4">
                    <label for="studentMessage" class="block text-sm font-medium text-gray-700 mb-1">
                        Message *
                    </label>
                    <textarea id="studentMessage" name="studentMessage" rows="8"
                              class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Type your email message here...">Dear Parent,

This message is regarding your child's progress and activities at school.

Best regards,
School Administration</textarea>
                </div>

                <button onclick="sendToStudent()" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                    <i class="fas fa-user-graduate mr-2"></i>Send to Student's Contacts
                </button>
            </div>

            <!-- Send to Class Tab -->
            <div id="classTabContent" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Class Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Class</label>
                        <select id="classSelect" class="w-full p-3 border border-gray-300 rounded-md">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class }}">{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Section (Optional)</label>
                        <select id="sectionSelect" class="w-full p-3 border border-gray-300 rounded-md">
                            <option value="">All Sections</option>
                        </select>
                    </div>

                    <!-- Send To Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Send To</label>
                        <div class="grid grid-cols-1 gap-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="father" class="form-radio text-blue-500" checked>
                                <span class="ml-2">Father</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="mother" class="form-radio text-blue-500">
                                <span class="ml-2">Mother</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="guardian" class="form-radio text-blue-500">
                                <span class="ml-2">Guardian</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="student" class="form-radio text-blue-500">
                                <span class="ml-2">Student</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="all" class="form-radio text-blue-500">
                                <span class="ml-2">All Contacts</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Class Info -->
                <div id="classInfo" class="mb-4 p-4 bg-blue-50 rounded-md hidden">
                    <h4 class="font-medium text-blue-700 mb-2">Class Information</h4>
                    <div class="text-sm text-blue-600">
                        <span id="studentCount">0</span> students found in <span id="classDescription">-</span>
                    </div>
                </div>

                <!-- Subject Input -->
                <div class="mb-4">
                    <label for="classSubject" class="block text-sm font-medium text-gray-700 mb-1">
                        Subject *
                    </label>
                    <input type="text" id="classSubject" name="classSubject" 
                           class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter email subject"
                           value="Class Announcement - {{ date('d/m/Y') }}">
                </div>

                <!-- Message Input -->
                <div class="mb-4">
                    <label for="classMessage" class="block text-sm font-medium text-gray-700 mb-1">
                        Message *
                    </label>
                    <textarea id="classMessage" name="classMessage" rows="8"
                              class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Type your email message here...">Dear Parents,

This is an important announcement for the entire class.

Best regards,
Class Teacher & School Administration</textarea>
                </div>

                <button onclick="sendToClass()" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                    <i class="fas fa-users mr-2"></i>Send to Entire Class
                </button>
            </div>

            <!-- Bulk Send Tab -->
            <div id="bulkTabContent" class="tab-content hidden">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Addresses (one per line)</label>
                    <textarea id="bulkEmails" rows="6" class="w-full p-2 border border-gray-300 rounded-md" 
                              placeholder="parent1@example.com&#10;parent2@example.com&#10;parent3@example.com"></textarea>
                </div>

                <div class="mb-4">
                    <label for="bulkSubject" class="block text-sm font-medium text-gray-700 mb-1">
                        Subject *
                    </label>
                    <input type="text" id="bulkSubject" name="bulkSubject" 
                           class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter email subject"
                           value="School Announcement - {{ date('d/m/Y') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="bulkMessage" rows="6" class="w-full p-2 border border-gray-300 rounded-md"
                              placeholder="Type your email message here...">Dear Parents,

This is a general announcement from the school.

Best regards,
School Administration</textarea>
                </div>

                <button onclick="sendBulkEmails()" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>Send Bulk Emails
                </button>
            </div>

            <!-- Result Display -->
            <div id="result" class="mt-4 hidden p-4 rounded-md"></div>
        </div>
    </div>

    <script>
        // Tab management
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + 'TabContent').classList.remove('hidden');
            
            // Activate selected tab
            document.getElementById(tabName + 'Tab').classList.add('border-blue-500', 'text-blue-600');
            document.getElementById(tabName + 'Tab').classList.remove('border-transparent', 'text-gray-500');
        }

        // Student selection handler
        document.getElementById('studentSelect').addEventListener('change', function(e) {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                // Show student details
                document.getElementById('studentDetails').classList.remove('hidden');
                
                // Update email info from data attributes
                document.getElementById('fatherEmail').textContent = selectedOption.dataset.fatherEmail || 'Not available';
                document.getElementById('motherEmail').textContent = selectedOption.dataset.motherEmail || 'Not available';
                document.getElementById('guardianEmail').textContent = selectedOption.dataset.guardianEmail || 'Not available';
                document.getElementById('studentEmail').textContent = selectedOption.dataset.studentEmail || 'Not available';
                
                // Update subject with student name
                const studentName = selectedOption.text.split(' - ')[0];
                document.getElementById('studentSubject').value = `Regarding ${studentName} - ${new Date().toLocaleDateString()}`;
            } else {
                document.getElementById('studentDetails').classList.add('hidden');
            }
        });

        // Class selection handler
        document.getElementById('classSelect').addEventListener('change', function(e) {
            const classValue = this.value;
            if (classValue) {
                fetchStudentsByClass(classValue);
                fetchSectionsByClass(classValue);
                
                // Update subject with class name
                document.getElementById('classSubject').value = `Class ${classValue} Announcement - ${new Date().toLocaleDateString()}`;
            } else {
                document.getElementById('classInfo').classList.add('hidden');
                document.getElementById('sectionSelect').innerHTML = '<option value="">All Sections</option>';
            }
        });

        // Section selection handler
        document.getElementById('sectionSelect').addEventListener('change', function(e) {
            const classValue = document.getElementById('classSelect').value;
            if (classValue && this.value) {
                fetchStudentsByClass(classValue, this.value);
            } else if (classValue) {
                fetchStudentsByClass(classValue);
            }
        });

        // Fetch students by class
        async function fetchStudentsByClass(className, section = '') {
            try {
                let url = `/whatsapp/students-by-class?class=${className}`;
                if (section) {
                    url += `&section=${section}`;
                }

                const response = await fetch(url);
                const result = await response.json();
                
                if (result.success) {
                    const students = result.data;
                    document.getElementById('studentCount').textContent = students.length;
                    
                    let classDescription = `${className}`;
                    if (section) {
                        classDescription += ` - Section ${section}`;
                    }
                    document.getElementById('classDescription').textContent = classDescription;
                    
                    document.getElementById('classInfo').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error fetching students by class:', error);
            }
        }

        // Fetch sections by class
        async function fetchSectionsByClass(className) {
            try {
                const response = await fetch(`/whatsapp/sections-by-class?class=${className}`);
                const result = await response.json();
                
                if (result.success) {
                    const sections = result.data;
                    const sectionSelect = document.getElementById('sectionSelect');
                    sectionSelect.innerHTML = '<option value="">All Sections</option>';
                    
                    sections.forEach(section => {
                        sectionSelect.innerHTML += `<option value="${section}">Section ${section}</option>`;
                    });
                }
            } catch (error) {
                console.error('Error fetching sections by class:', error);
            }
        }

        // Show result message
        function showResult(message, type) {
            const resultDiv = document.getElementById('result');
            resultDiv.className = `mt-4 p-4 rounded-md ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
            resultDiv.innerHTML = message;
            resultDiv.classList.remove('hidden');
            
            setTimeout(() => {
                resultDiv.classList.add('hidden');
            }, 5000);
        }

        // Send single email
        async function sendEmail() {
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            const cc = document.getElementById('cc').value.split(',').map(e => e.trim()).filter(e => e);
            const bcc = document.getElementById('bcc').value.split(',').map(e => e.trim()).filter(e => e);

            if (!email || !subject || !message) {
                showResult('Please fill all required fields', 'error');
                return;
            }

            try {
                const response = await fetch('/email/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        email, 
                        subject, 
                        message,
                        cc,
                        bcc
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showResult('✅ Email sent successfully!', 'success');
                } else {
                    showResult('❌ Failed to send: ' + (result.error || 'Unknown error'), 'error');
                }
            } catch (error) {
                showResult('❌ Network error: ' + error.message, 'error');
            }
        }

        // Send to student
        async function sendToStudent() {
            const studentId = document.getElementById('studentSelect').value;
            const subject = document.getElementById('studentSubject').value;
            const message = document.getElementById('studentMessage').value;
            const sendTo = document.querySelector('input[name="send_to_student"]:checked').value;

            if (!studentId || !subject || !message) {
                showResult('Please select a student and fill all required fields', 'error');
                return;
            }

            try {
                const response = await fetch('/email/send-to-student', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        student_id: studentId, 
                        subject, 
                        message, 
                        send_to: sendTo 
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showResult(`✅ ${result.message}`, 'success');
                } else {
                    showResult('❌ Failed to send: ' + (result.error || 'Unknown error'), 'error');
                }
            } catch (error) {
                showResult('❌ Network error: ' + error.message, 'error');
            }
        }

        // Send to class
        async function sendToClass() {
            const classValue = document.getElementById('classSelect').value;
            const section = document.getElementById('sectionSelect').value;
            const subject = document.getElementById('classSubject').value;
            const message = document.getElementById('classMessage').value;
            const sendTo = document.querySelector('input[name="send_to_class"]:checked').value;

            if (!classValue || !subject || !message) {
                showResult('Please select a class and fill all required fields', 'error');
                return;
            }

            try {
                const response = await fetch('/email/send-to-class', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        class: classValue, 
                        section, 
                        subject, 
                        message, 
                        send_to: sendTo 
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showResult(`✅ ${result.message}`, 'success');
                } else {
                    showResult('❌ Failed to send: ' + (result.error || 'Unknown error'), 'error');
                }
            } catch (error) {
                showResult('❌ Network error: ' + error.message, 'error');
            }
        }

        // Send bulk emails
        async function sendBulkEmails() {
            const emailsText = document.getElementById('bulkEmails').value;
            const subject = document.getElementById('bulkSubject').value;
            const message = document.getElementById('bulkMessage').value;

            if (!emailsText || !subject || !message) {
                showResult('Please fill all required fields', 'error');
                return;
            }

            const emails = emailsText.split('\n').filter(email => email.trim() !== '');

            try {
                const response = await fetch('/email/send-bulk', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        emails, 
                        subject, 
                        message 
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showResult(`✅ ${result.message}`, 'success');
                } else {
                    showResult('❌ Failed to send bulk emails: ' + (result.error || 'Unknown error'), 'error');
                }
            } catch (error) {
                showResult('❌ Network error: ' + error.message, 'error');
            }
        }

        // Test email configuration
        async function testEmail() {
            const email = document.getElementById('email').value || '{{ auth()->user()->email ?? "test@example.com" }}';

            try {
                const response = await fetch('/email/test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email })
                });

                const result = await response.json();

                if (result.success) {
                    showResult('✅ Test email sent successfully! Check your inbox.', 'success');
                } else {
                    showResult('❌ Test failed: ' + (result.error || 'Unknown error'), 'error');
                }
            } catch (error) {
                showResult('❌ Network error: ' + error.message, 'error');
            }
        }

        // Initialize the first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('single');
        });
    </script>
</body>
</html>