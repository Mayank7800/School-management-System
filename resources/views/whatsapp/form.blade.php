<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School WhatsApp Messenger</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center mb-6">
                <i class="fab fa-whatsapp text-green-500 text-3xl mr-3"></i>
                <h1 class="text-2xl font-bold text-gray-800">School WhatsApp Messenger</h1>
            </div>

            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button id="singleTab" class="tab-button py-2 px-1 border-b-2 border-green-500 font-medium text-sm text-green-600" onclick="switchTab('single')">
                        Single Message
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

            <!-- Single Message Tab -->
            <div id="singleTabContent" class="tab-content">
                <!-- Template Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quick Templates</label>
                    <select id="templateSelect" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="">Select a template</option>
                        <optgroup label="Attendance">
                            <option value="attendance_present">Present Alert</option>
                            <option value="attendance_absent">Absent Alert</option>
                        </optgroup>
                        <optgroup label="Fee">
                            <option value="fee_reminder">Fee Reminder</option>
                            <option value="fee_paid">Fee Paid Confirmation</option>
                        </optgroup>
                        <optgroup label="Academic">
                            <option value="homework">Homework</option>
                            <option value="exam">Exam Schedule</option>
                        </optgroup>
                        <optgroup label="General">
                            <option value="ptm">PTM Announcement</option>
                            <option value="holiday">Holiday Announcement</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Mobile Number Input -->
                <div class="mb-4">
                    <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">
                        Mobile Number *
                    </label>
                    <input type="text" id="mobile" name="mobile" 
                           class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Enter mobile number (e.g., 9898989898 or 919898989898)"
                           value="9898989898">
                </div>

                <!-- Message Input -->
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                        Message *
                    </label>
                    <textarea id="message" name="message" rows="6"
                              class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent"
                              placeholder="Type your message here..."></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button onclick="sendMessage()" 
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>Send Message
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
                                        data-father-contact="{{ $student->father_contact }}"
                                        data-mother-contact="{{ $student->mother_contact }}"
                                        data-guardian-contact="{{ $student->guardian_contact }}"
                                        data-student-mobile="{{ $student->mobile_no }}">
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
                                <input type="radio" name="send_to_student" value="father" class="form-radio text-green-500" checked>
                                <span class="ml-2">Father</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_student" value="mother" class="form-radio text-green-500">
                                <span class="ml-2">Mother</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_student" value="guardian" class="form-radio text-green-500">
                                <span class="ml-2">Guardian</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_student" value="student" class="form-radio text-green-500">
                                <span class="ml-2">Student</span>
                            </label>
                            <label class="inline-flex items-center col-span-2">
                                <input type="radio" name="send_to_student" value="all" class="form-radio text-green-500">
                                <span class="ml-2">All Contacts</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Student Details -->
                <div id="studentDetails" class="mb-4 p-4 bg-gray-50 rounded-md hidden">
                    <h4 class="font-medium text-gray-700 mb-2">Student Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div><span class="font-medium">Admission No:</span> <span id="admissionNo">-</span></div>
                        <div><span class="font-medium">Class:</span> <span id="studentClass">-</span></div>
                        <div><span class="font-medium">Father:</span> <span id="fatherName">-</span></div>
                        <div><span class="font-medium">Father Mobile:</span> <span id="fatherContact">-</span></div>
                        <div><span class="font-medium">Mother:</span> <span id="motherName">-</span></div>
                        <div><span class="font-medium">Mother Mobile:</span> <span id="motherContact">-</span></div>
                        <div><span class="font-medium">Guardian:</span> <span id="guardianName">-</span></div>
                        <div><span class="font-medium">Guardian Mobile:</span> <span id="guardianContact">-</span></div>
                        <div><span class="font-medium">Student Mobile:</span> <span id="studentMobile">-</span></div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="mb-4">
                    <label for="studentMessage" class="block text-sm font-medium text-gray-700 mb-1">
                        Message *
                    </label>
                    <textarea id="studentMessage" name="studentMessage" rows="6"
                              class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent"
                              placeholder="Type your message here..."></textarea>
                </div>

                <button onclick="sendToStudent()" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
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
                                <input type="radio" name="send_to_class" value="father" class="form-radio text-green-500" checked>
                                <span class="ml-2">Father</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="mother" class="form-radio text-green-500">
                                <span class="ml-2">Mother</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="guardian" class="form-radio text-green-500">
                                <span class="ml-2">Guardian</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="student" class="form-radio text-green-500">
                                <span class="ml-2">Student</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="send_to_class" value="all" class="form-radio text-green-500">
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

                <!-- Message Input -->
                <div class="mb-4">
                    <label for="classMessage" class="block text-sm font-medium text-gray-700 mb-1">
                        Message *
                    </label>
                    <textarea id="classMessage" name="classMessage" rows="6"
                              class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-transparent"
                              placeholder="Type your message here..."></textarea>
                </div>

                <button onclick="sendToClass()" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                    <i class="fas fa-users mr-2"></i>Send to Entire Class
                </button>
            </div>

            <!-- Bulk Send Tab -->
            <div id="bulkTabContent" class="tab-content hidden">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Numbers (one per line)</label>
                    <textarea id="bulkNumbers" rows="6" class="w-full p-2 border border-gray-300 rounded-md" 
                              placeholder="9898989898&#10;9898999999&#10;9898977777"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="bulkMessage" rows="4" class="w-full p-2 border border-gray-300 rounded-md"></textarea>
                </div>
                <button onclick="sendBulkMessages()" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>Send Bulk Messages
                </button>
            </div>

            <!-- Result Display -->
            <div id="result" class="mt-4 hidden p-4 rounded-md"></div>
        </div>
    </div>

    <script>
        // Template messages
        const templates = {
            'attendance_present': 'Dear parent, your child @{{student_name}} was present today in school. Attendance Date: @{{date}}',
            'attendance_absent': 'Dear parent, your child @{{student_name}} was absent today. Please inform the school about the reason. Date: @{{date}}',
            'fee_reminder': 'Dear parent, the school fee of ₹@{{amount}} for @{{month}} is due. Please pay before @{{due_date}}.',
            'fee_paid': 'Dear parent, fee of ₹@{{amount}} for @{{month}} has been received. Thank you! Receipt No: @{{receipt_no}}',
            'homework': 'Homework for @{{subject}}: @{{homework_details}}. Due date: @{{due_date}}',
            'exam': 'Exam schedule: @{{exam_name}} on @{{exam_date}}. Venue: @{{venue}}. All the best!',
            'ptm': 'Parent Teacher Meeting scheduled on @{{date}} at @{{time}}. Please be present.',
            'holiday': 'School will remain closed on @{{date}} for @{{reason}}. Happy holidays!'
        };

        // Tab management
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-green-500', 'text-green-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + 'TabContent').classList.remove('hidden');
            
            // Activate selected tab
            document.getElementById(tabName + 'Tab').classList.add('border-green-500', 'text-green-600');
            document.getElementById(tabName + 'Tab').classList.remove('border-transparent', 'text-gray-500');
        }

        // Template selection handler
        document.getElementById('templateSelect').addEventListener('change', function(e) {
            if (templates[e.target.value]) {
                document.getElementById('message').value = templates[e.target.value];
                document.getElementById('studentMessage').value = templates[e.target.value];
                document.getElementById('classMessage').value = templates[e.target.value];
                document.getElementById('bulkMessage').value = templates[e.target.value];
            }
        });

        // Student selection handler
        document.getElementById('studentSelect').addEventListener('change', function(e) {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                // Show student details
                document.getElementById('studentDetails').classList.remove('hidden');
                
                // Update basic contact info from data attributes
                document.getElementById('fatherContact').textContent = selectedOption.dataset.fatherContact || '-';
                document.getElementById('motherContact').textContent = selectedOption.dataset.motherContact || '-';
                document.getElementById('guardianContact').textContent = selectedOption.dataset.guardianContact || '-';
                document.getElementById('studentMobile').textContent = selectedOption.dataset.studentMobile || '-';
                
                // Fetch complete student details
                fetchStudentDetails(selectedOption.value);
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

        // Fetch student details
        async function fetchStudentDetails(studentId) {
            try {
                const response = await fetch(`/whatsapp/student-details/${studentId}`);
                const result = await response.json();
                
                if (result.success) {
                    const student = result.data.student;
                    document.getElementById('admissionNo').textContent = student.admission_no || '-';
                    document.getElementById('studentClass').textContent = student.class + (student.section ? ` - ${student.section}` : '');
                    document.getElementById('fatherName').textContent = student.father_name || '-';
                    document.getElementById('motherName').textContent = student.mother_name || '-';
                    document.getElementById('guardianName').textContent = student.guardian_name || '-';
                    
                    // Update contact numbers (use fetched data which might be more accurate)
                    if (student.father_contact) {
                        document.getElementById('fatherContact').textContent = student.father_contact;
                    }
                    if (student.mother_contact) {
                        document.getElementById('motherContact').textContent = student.mother_contact;
                    }
                    if (student.guardian_contact) {
                        document.getElementById('guardianContact').textContent = student.guardian_contact;
                    }
                    if (student.mobile_no) {
                        document.getElementById('studentMobile').textContent = student.mobile_no;
                    }
                }
            } catch (error) {
                console.error('Error fetching student details:', error);
            }
        }

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

        // Send single message
        async function sendMessage() {
            const mobile = document.getElementById('mobile').value;
            const message = document.getElementById('message').value;

            if (!mobile || !message) {
                showResult('Please enter both mobile number and message', 'error');
                return;
            }

            try {
                const response = await fetch('/whatsapp/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ mobile, message })
                });

                const result = await response.json();

                if (result.success) {
                    showResult('✅ Message sent successfully!', 'success');
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
            const message = document.getElementById('studentMessage').value;
            const sendTo = document.querySelector('input[name="send_to_student"]:checked').value;

            if (!studentId || !message) {
                showResult('Please select a student and enter a message', 'error');
                return;
            }

            try {
                const response = await fetch('/whatsapp/send-to-student', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ student_id: studentId, message, send_to: sendTo })
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
            const message = document.getElementById('classMessage').value;
            const sendTo = document.querySelector('input[name="send_to_class"]:checked').value;

            if (!classValue || !message) {
                showResult('Please select a class and enter a message', 'error');
                return;
            }

            try {
                const response = await fetch('/whatsapp/send-to-class', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ class: classValue, section, message, send_to: sendTo })
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

        // Send bulk messages
        async function sendBulkMessages() {
            const numbersText = document.getElementById('bulkNumbers').value;
            const message = document.getElementById('bulkMessage').value;

            if (!numbersText || !message) {
                showResult('Please enter both numbers and message', 'error');
                return;
            }

            const numbers = numbersText.split('\n').filter(num => num.trim() !== '');

            try {
                const response = await fetch('/whatsapp/send-bulk', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ numbers, message })
                });

                const result = await response.json();

                if (result.success) {
                    showResult(`✅ Bulk messages sent! ${result.message}`, 'success');
                } else {
                    showResult('❌ Failed to send bulk messages: ' + (result.error || 'Unknown error'), 'error');
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