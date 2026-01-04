@extends('layouts.app')

@section('title', 'Record Payment')
@section('page_title', 'Record Payment')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Student Search Section --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-search"></i> Search Student</h5>
                </div>
                <div class="card-body">
                    <form id="studentSearchForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Search By <span class="text-danger">*</span></label>
                            <select class="form-select" id="searchType" required>
                                <option value="">-- Select Search Type --</option>
                                <option value="admission_no">Admission Number</option>
                                <option value="class">Class</option>
                            </select>
                        </div>
                        
                        <div class="mb-3" id="admissionSearchGroup">
                            <label class="form-label">Admission Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="admissionNo" placeholder="Enter admission number">
                        </div>
                        
                        <div class="mb-3" id="classSearchGroup" style="display: none;">
                            <label class="form-label">Select Class <span class="text-danger">*</span></label>
                            <select class="form-select" id="classSearch">
                                <option value="">-- Select Class --</option>
                                @foreach($courses as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="button" class="btn btn-primary w-100" id="searchStudent">
                            <i class="bi bi-search"></i> Search Student
                        </button>
                    </form>
                </div>
            </div>

            {{-- Student List Card --}}
            <div class="card shadow-sm border-0" id="studentListCard" style="display: none;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-people"></i> Select Student</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" id="studentList">
                        <!-- Students will be listed here -->
                    </div>
                </div>
            </div>

            {{-- Student Details Card --}}
            <div class="card shadow-sm border-0" id="studentDetailsCard" style="display: none;">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Student Details</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="student-avatar bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                            <i class="bi bi-person"></i>
                        </div>
                        <h6 class="mt-2 mb-1" id="infoName">-</h6>
                        <small class="text-muted" id="infoAdmissionNo">-</small>
                    </div>
                    
                    <div class="student-info">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Class:</strong></td>
                                <td id="infoClass">-</td>
                            </tr>
                            <tr>
                                <td><strong>Section:</strong></td>
                                <td id="infoSection">-</td>
                            </tr>
                            <tr>
                                <td><strong>Father:</strong></td>
                                <td id="infoFather">-</td>
                            </tr>
                            <tr>
                                <td><strong>Mobile:</strong></td>
                                <td id="infoMobile">-</td>
                            </tr>
                        </table>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm w-100" id="changeStudent">
                        <i class="bi bi-arrow-left"></i> Change Student
                    </button>
                </div>
            </div>
        </div>

        {{-- Payment Form Section --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-credit-card"></i> Record Payment</h5>
                </div>
                <div class="card-body">
                    {{-- Alert Messages --}}
                    <div id="alertContainer"></div>

                    {{-- No Student Selected Message --}}
                    <div id="noStudentMessage" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-person-x" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">No Student Selected</h4>
                            <p>Please search and select a student to record payment.</p>
                        </div>
                    </div>

                    {{-- Fee Summary --}}
                    <div class="row mb-4" id="feeSummary" style="display: none;">
                        <div class="col-md-3">
                            <div class="card bg-light border">
                                <div class="card-body text-center p-3">
                                    <h6 class="card-title text-muted mb-1">Total Fees</h6>
                                    <h4 class="text-primary mb-0" id="totalFees">₹0.00</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border">
                                <div class="card-body text-center p-3">
                                    <h6 class="card-title text-muted mb-1">Paid Amount</h6>
                                    <h4 class="text-success mb-0" id="paidAmount">₹0.00</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border">
                                <div class="card-body text-center p-3">
                                    <h6 class="card-title text-muted mb-1">Due Amount</h6>
                                    <h4 class="text-danger mb-0" id="dueAmount">₹0.00</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border">
                                <div class="card-body text-center p-3">
                                    <h6 class="card-title text-muted mb-1">Status</h6>
                                    <span class="badge" id="paymentStatus">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Form --}}
                   {{-- Payment Form --}}
                    <form id="paymentForm" action="{{ route('fee-payments.store') }}" method="POST" novalidate style="display: none;" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="student_id" id="formStudentId">
                        <input type="hidden" name="student_fee_id" id="formStudentFeeId">

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Amount Paid (₹) <span class="text-danger">*</span></label>
                                <input type="number" name="amount_paid" step="0.01" class="form-control" min="1" required id="amount_paid">
                                <small class="text-muted" id="due_amount_info">Due amount: ₹0.00</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_mode" class="form-select" id="payment_method" required>
                                    <option value="">-- Select Method --</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Online Transfer">Online Transfer</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Card">Card</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3" id="paymentDetails" style="display: none;">
                            <div class="col-md-4">
                                <label class="form-label">Transaction Reference</label>
                                <input type="text" name="transaction_ref" class="form-control" placeholder="Cheque no, UTR, Transaction ID">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" placeholder="Bank name (if applicable)">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cheque No.</label>
                                <input type="text" name="cheque_no" class="form-control" placeholder="Cheque number">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Received By <span class="text-danger">*</span></label>
                                <input type="text" name="received_by" class="form-control" value="{{ auth()->user()->name ?? '' }}" placeholder="Staff name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Receipt Upload (optional)</label>
                                <input type="file" name="receipt_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Max size: 5MB, Formats: PDF, JPG, JPEG, PNG</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks (optional)</label>
                            <textarea name="remarks" class="form-control" rows="2" placeholder="Any additional notes..."></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-circle"></i> Record Payment
                            </button>
                            <button type="button" class="btn btn-secondary px-4" onclick="clearSelection()">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 10px; margin-bottom: 1rem; }
    .student-avatar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .list-group-item { border: none; padding: 0.75rem 1rem; }
    .list-group-item:hover { background-color: #f8f9fa; }
    .list-group-item.active { background-color: #007bff; color: white; }
    .badge { font-size: 0.8em; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchType = document.getElementById('searchType');
    const admissionSearchGroup = document.getElementById('admissionSearchGroup');
    const classSearchGroup = document.getElementById('classSearchGroup');
    const admissionNo = document.getElementById('admissionNo');
    const classSearch = document.getElementById('classSearch');
    const searchStudentBtn = document.getElementById('searchStudent');
    const studentListCard = document.getElementById('studentListCard');
    const studentDetailsCard = document.getElementById('studentDetailsCard');
    const studentList = document.getElementById('studentList');
    const changeStudentBtn = document.getElementById('changeStudent');
    const feeSummary = document.getElementById('feeSummary');
    const paymentForm = document.getElementById('paymentForm');
    const noStudentMessage = document.getElementById('noStudentMessage');
    const paymentMethod = document.getElementById('payment_method');
    const paymentDetails = document.getElementById('paymentDetails');
    const amountPaid = document.getElementById('amount_paid');
    const dueAmountInfo = document.getElementById('due_amount_info');
    const alertContainer = document.getElementById('alertContainer');

    let currentDueAmount = 0;
    let currentStudentId = null;
    let currentStudentFeeId = null;

    // Get CSRF token safely
    function getCsrfToken() {
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (csrfMeta) {
            return csrfMeta.getAttribute('content');
        }
        
        const csrfInput = document.querySelector('input[name="_token"]');
        if (csrfInput) {
            return csrfInput.value;
        }
        
        return 'csrf-token-not-found';
    }

    // Search type change
    searchType.addEventListener('change', function() {
        const type = this.value;
        
        if (type === 'admission_no') {
            admissionSearchGroup.style.display = 'block';
            classSearchGroup.style.display = 'none';
        } else if (type === 'class') {
            admissionSearchGroup.style.display = 'none';
            classSearchGroup.style.display = 'block';
        } else {
            admissionSearchGroup.style.display = 'none';
            classSearchGroup.style.display = 'none';
        }
        
        clearResults();
    });

    // Search student
    searchStudentBtn.addEventListener('click', function() {
        const searchTypeVal = searchType.value;
        let searchValue = '';

        if (!searchTypeVal) {
            showAlert('Please select search type', 'warning');
            return;
        }

        if (searchTypeVal === 'admission_no') {
            searchValue = admissionNo.value.trim();
            if (!searchValue) {
                showAlert('Please enter admission number', 'warning');
                return;
            }
        } else if (searchTypeVal === 'class') {
            searchValue = classSearch.value;
            if (!searchValue) {
                showAlert('Please select a class', 'warning');
                return;
            }
        }

        searchStudents(searchTypeVal, searchValue);
    });

    // Search students function
    function searchStudents(type, value) {
        const btn = searchStudentBtn;
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Searching...';
        btn.disabled = true;

        fetch(`/sms/search-students?type=${type}&value=${encodeURIComponent(value)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (data.students && data.students.length > 0) {
                        displayStudentList(data.students);
                    } else {
                        showAlert('No students found', 'info');
                        clearResults();
                    }
                } else {
                    showAlert(data.message || 'Search failed', 'danger');
                    clearResults();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error searching students', 'danger');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }

    // Display student list
    function displayStudentList(students) {
        studentList.innerHTML = '';
        
        students.forEach(student => {
            const listItem = document.createElement('a');
            listItem.href = '#';
            listItem.className = 'list-group-item list-group-item-action';
            listItem.innerHTML = `
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${student.first_name} ${student.last_name}</h6>
                    <small>${student.admission_no}</small>
                </div>
                <p class="mb-1">Class: ${student.class_name} | Section: ${student.section || 'N/A'}</p>
                <small>Father: ${student.father_name || 'N/A'}</small>
            `;
            listItem.addEventListener('click', function(e) {
                e.preventDefault();
                selectStudent(student);
            });
            studentList.appendChild(listItem);
        });
        
        studentListCard.style.display = 'block';
        studentDetailsCard.style.display = 'none';
        paymentForm.style.display = 'none';
        feeSummary.style.display = 'none';
        noStudentMessage.style.display = 'none';
    }

    // Select student
    function selectStudent(student) {
        // Update student details
        document.getElementById('infoName').textContent = `${student.first_name} ${student.last_name}`;
        document.getElementById('infoAdmissionNo').textContent = student.admission_no;
        document.getElementById('infoClass').textContent = student.class_name;
        document.getElementById('infoSection').textContent = student.section || 'N/A';
        document.getElementById('infoFather').textContent = student.father_name || 'N/A';
        document.getElementById('infoMobile').textContent = student.mobile || 'N/A';
        
        // Set hidden form field
        document.getElementById('formStudentId').value = student.id;
        currentStudentId = student.id;
        
        // Show student details and hide list
        studentDetailsCard.style.display = 'block';
        studentListCard.style.display = 'none';
        
        // Load student fees
        loadStudentFees(student.id);
    }

    // Load student fees
    function loadStudentFees(studentId) {
        fetch(`/sms/student-fees-payment/${studentId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    displayFeeSummary(data.feeSummary);
                    paymentForm.style.display = 'block';
                    noStudentMessage.style.display = 'none';
                    
                    document.getElementById('formStudentFeeId').value = data.feeStructureId;
                    currentStudentFeeId = data.feeStructureId;
                    currentDueAmount = data.feeSummary.due_amount;
                    
                    dueAmountInfo.textContent = `Due amount: ₹${currentDueAmount.toFixed(2)}`;
                    amountPaid.max = currentDueAmount;
                    amountPaid.value = currentDueAmount > 0 ? currentDueAmount : '';
                    
                } else {
                    showAlert(data.message || 'No fee structure found', 'warning');
                    paymentForm.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error loading fee details', 'danger');
            });
    }

    // Display fee summary
    function displayFeeSummary(summary) {
        document.getElementById('totalFees').textContent = `₹${summary.total_fees.toFixed(2)}`;
        document.getElementById('paidAmount').textContent = `₹${summary.paid_amount.toFixed(2)}`;
        document.getElementById('dueAmount').textContent = `₹${summary.due_amount.toFixed(2)}`;
        
        const statusElement = document.getElementById('paymentStatus');
        statusElement.textContent = summary.payment_status;
        statusElement.className = 'badge ' + getStatusBadgeClass(summary.payment_status);
        
        feeSummary.style.display = 'flex';
    }

    // Payment method change
    paymentMethod.addEventListener('change', function() {
        if (this.value === 'Cash') {
            paymentDetails.style.display = 'none';
        } else {
            paymentDetails.style.display = 'flex';
        }
    });

    // Change student
    changeStudentBtn.addEventListener('click', function() {
        clearSelection();
    });

    // Clear selection
    window.clearSelection = function() {
        studentDetailsCard.style.display = 'none';
        studentListCard.style.display = 'none';
        paymentForm.style.display = 'none';
        feeSummary.style.display = 'none';
        noStudentMessage.style.display = 'block';
        currentDueAmount = 0;
        currentStudentId = null;
        currentStudentFeeId = null;
        
        // Reset form
        document.getElementById('studentSearchForm').reset();
        document.getElementById('paymentForm').reset();
    };

    // Get status badge class
    function getStatusBadgeClass(status) {
        const classes = {
            'Paid': 'bg-success',
            'Partial': 'bg-warning',
            'Unpaid': 'bg-danger'
        };
        return classes[status] || 'bg-secondary';
    }

    // Show alert
    function showAlert(message, type) {
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Add to container
        const container = document.getElementById('alertContainer');
        container.innerHTML = '';
        container.appendChild(alert);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // === SINGLE FORM SUBMISSION HANDLER ===
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submission started...');
        
        const amount = parseFloat(amountPaid.value) || 0;
        
        if (amount > currentDueAmount) {
            showAlert(`Amount paid (₹${amount.toFixed(2)}) cannot exceed due amount (₹${currentDueAmount.toFixed(2)})`, 'danger');
            amountPaid.focus();
            return;
        }

        if (!currentStudentId || !currentStudentFeeId) {
            showAlert('Please select a student first', 'warning');
            return;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
        submitBtn.disabled = true;

        // Create FormData
        const formData = new FormData(this);
        const csrfToken = getCsrfToken();

        console.log('Submitting form data...');

        // Submit via AJAX
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            console.log('Response received:', response.status);
            
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json().then(data => {
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                });
            } else {
                // Handle non-JSON response (redirect, HTML, etc.)
                return response.text().then(text => {
                    console.log('Non-JSON response:', text);
                    throw new Error('Server is redirecting or returned HTML. Check if store method returns JSON.');
                });
            }
        })
        .then(data => {
            console.log('Success:', data);
            
            if (data.success) {
                showAlert(data.message || 'Payment recorded successfully!', 'success');
                
                // Redirect after delay
                setTimeout(() => {
                    window.location.href = data.redirect_url || '{{ route("fee-payments.index") }}';
                }, 1500);
            } else {
                throw new Error(data.message || 'Payment failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            let errorMessage = 'Payment failed. Please try again.';
            
            if (error.errors) {
                // Laravel validation errors
                errorMessage = Object.values(error.errors).flat().join('<br>');
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            showAlert(errorMessage, 'danger');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    // Enter key support
    admissionNo.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchStudentBtn.click();
        }
    });
});
</script>
@endsection