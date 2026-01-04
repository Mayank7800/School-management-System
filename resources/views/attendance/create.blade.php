@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-calendar-check fa-2x me-3"></i>
                <div>
                    <h4 class="mb-0 fw-bold">Mark Student Attendance</h4>
                    <small class="opacity-80">Record daily attendance for students</small>
                </div>
            </div>
        </div>

        <div class="card-body p-4">

            {{-- STEP 1: Select Class --}}
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="class-selection-card p-4 border rounded-3 bg-light">
                        <label class="form-label fw-semibold text-dark mb-3">
                            <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                            Select Class
                        </label>
                        <select id="classSelect" class="form-select form-select-lg shadow-sm">
                            <option value="">-- Choose a Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Select a class to view students and mark attendance
                        </small>
                    </div>
                </div>
                
                {{-- Quick Stats --}}
                <div class="col-lg-6">
                    <div class="stats-card p-4 border rounded-3 bg-white">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>
                            Today's Summary
                        </h6>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border-end">
                                    <div class="h4 mb-1 text-primary fw-bold" id="totalStudents">0</div>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-end">
                                    <div class="h4 mb-1 text-success fw-bold" id="presentCount">0</div>
                                    <small class="text-muted">Present</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div>
                                    <div class="h4 mb-1 text-danger fw-bold" id="absentCount">0</div>
                                    <small class="text-muted">Absent</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 2: Attendance Form --}}
            <form action="{{ route('attendance.store') }}" method="POST" id="attendanceForm" style="display:none;">
                @csrf
                <input type="hidden" name="class_id" id="selectedClassId">

                <div class="attendance-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-users me-2 text-primary"></i>
                            Student Attendance
                        </h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="markAllPresent">
                                <i class="fas fa-check-circle me-1"></i>Mark All Present
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="markAllAbsent">
                                <i class="fas fa-times-circle me-1"></i>Mark All Absent
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" width="5%">#</th>
                                    <th width="35%">Student Name</th>
                                    <th width="25%">Status</th>
                                    <th width="35%">Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTableBody" class="border-top-0">
                                {{-- Filled dynamically --}}
                            </tbody>
                        </table>
                    </div>

                    {{-- No Students Message --}}
                    <div id="noStudentsMessage" class="text-center py-5" style="display: none;">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No students found in this class</h5>
                        <p class="text-muted">Please select a different class or add students to this class.</p>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            <i class="fas fa-save me-2"></i>Save Attendance
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 16px;
        border: none;
    }

    .card-header {
        border-radius: 16px 16px 0 0 !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .form-select-lg {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .form-select-lg:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: translateY(-1px);
    }

    .class-selection-card, .stats-card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .class-selection-card:hover, .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .table th {
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        background-color: #f8f9fa;
        padding: 1rem;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
        transition: all 0.2s ease;
    }

    .status-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .status-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    .attendance-section {
        animation: fadeIn 0.6s ease-in;
    }

    /* Status-specific row coloring */
    .status-present { background-color: rgba(40, 167, 69, 0.05) !important; }
    .status-absent { background-color: rgba(220, 53, 69, 0.05) !important; }
    .status-late { background-color: rgba(255, 193, 7, 0.05) !important; }
    .status-excused { background-color: rgba(23, 162, 184, 0.05) !important; }

    /* Custom scrollbar for table */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

<script>
const baseUrl = "{{ url('/') }}";

document.getElementById('classSelect').addEventListener('change', function() {
    let classId = this.value;
    document.getElementById('selectedClassId').value = classId;

    if (!classId) {
        document.getElementById('attendanceForm').style.display = 'none';
        document.getElementById('noStudentsMessage').style.display = 'none';
        resetStats();
        return;
    }

    // Show loading state
    const tbody = document.getElementById('studentsTableBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="4" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading students...</p>
            </td>
        </tr>
    `;
    document.getElementById('attendanceForm').style.display = 'block';
    document.getElementById('noStudentsMessage').style.display = 'none';

    fetch(`${baseUrl}/attendance/students/${classId}`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('studentsTableBody');
            tbody.innerHTML = "";

            if (data.length > 0) {
                data.forEach((student, index) => {
                    const row = document.createElement('tr');
                    row.className = 'fade-in';
                    row.innerHTML = `
                        <td class="ps-4 fw-semibold text-muted">${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40 me-3">
                                    <div class="symbol-label bg-light-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">${student.first_name} ${student.last_name}</div>
                                    <small class="text-muted">ID: ${student.admission_no}</small>
                                </div>
                            </div>
                            <input type="hidden" name="student_ids[]" value="${student.id}">
                        </td>
                        <td>
                            <select name="status[${student.id}]" class="form-select status-select" onchange="updateRowStatus(this)">
                                <option value="Present" selected>Present</option>
                                <option value="Absent">Absent</option>
                                <option value="Late">Late</option>
                                <option value="Excused">Excused</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" 
                                   name="remarks[${student.id}]" placeholder="Enter remarks (optional)"
                                   style="border-radius: 8px;">
                        </td>
                    `;
                    tbody.appendChild(row);
                });
                document.getElementById('noStudentsMessage').style.display = 'none';
                updateStats();
            } else {
                document.getElementById('noStudentsMessage').style.display = 'block';
                resetStats();
            }
        })
        .catch(error => {
            console.error('Error fetching students:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                        <p>Error loading students. Please try again.</p>
                    </td>
                </tr>
            `;
        });
});

// Update row background based on status
function updateRowStatus(select) {
    const row = select.closest('tr');
    // Remove all status classes
    row.classList.remove('status-present', 'status-absent', 'status-late', 'status-excused');
    // Add appropriate status class
    row.classList.add(`status-${select.value.toLowerCase()}`);
    updateStats();
}

// Update statistics
function updateStats() {
    const statusSelects = document.querySelectorAll('.status-select');
    let present = 0, absent = 0;
    
    statusSelects.forEach(select => {
        if (select.value === 'Present' || select.value === 'Late' || select.value === 'Excused') {
            present++;
        } else {
            absent++;
        }
    });
    
    document.getElementById('totalStudents').textContent = statusSelects.length;
    document.getElementById('presentCount').textContent = present;
    document.getElementById('absentCount').textContent = absent;
}

function resetStats() {
    document.getElementById('totalStudents').textContent = '0';
    document.getElementById('presentCount').textContent = '0';
    document.getElementById('absentCount').textContent = '0';
}

// Mark all buttons functionality
document.getElementById('markAllPresent').addEventListener('click', function() {
    document.querySelectorAll('.status-select').forEach(select => {
        select.value = 'Present';
        updateRowStatus(select);
    });
});

document.getElementById('markAllAbsent').addEventListener('click', function() {
    document.querySelectorAll('.status-select').forEach(select => {
        select.value = 'Absent';
        updateRowStatus(select);
    });
});

// Add animation to form when displayed
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
            const form = document.getElementById('attendanceForm');
            if (form.style.display !== 'none') {
                form.classList.add('fade-in');
            }
        }
    });
});

observer.observe(document.getElementById('attendanceForm'), {
    attributes: true,
    attributeFilter: ['style']
});
</script>
@endsection