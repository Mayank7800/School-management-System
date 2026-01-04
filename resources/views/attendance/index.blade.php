@extends('layouts.app')

@section('title', 'Attendance Records')
@section('page_title', 'Attendance Records')

@section('content')
<div class="container-fluid py-2 py-md-4">

    <div class="row">
        {{-- LEFT: Class List - Hidden on mobile, accessible via button --}}
        <div class="col-12 col-md-3 d-none d-md-block">
            <div class="card shadow-lg border-0 mb-3 mb-md-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chalkboard-teacher fa-lg me-2"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Classes</h6>
                            <small class="opacity-80">Select a class to view attendance</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($classes as $class)
                            <button class="list-group-item list-group-item-action d-flex align-items-center py-3 class-item"
                                onclick="loadAttendance({{ $class->id }}, this)">
                                <div class="class-icon me-3">
                                    <i class="fas fa-users text-primary"></i>
                                </div>
                                <div class="flex-grow-1 text-start">
                                    <div class="fw-semibold text-dark">{{ $class->name }}</div>
                                    <small class="text-muted">Click to view records</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Quick Stats Card --}}
            <div class="card shadow-sm border-0 mt-3 stats-card">
                <div class="card-body text-center p-3">
                    <div class="row">
                        <div class="col-4">
                            <div class="border-end">
                                <div class="h5 mb-1 text-primary fw-bold" id="totalRecords">0</div>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <div class="h5 mb-1 text-success fw-bold" id="presentRecords">0</div>
                                <small class="text-muted">Present</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <div class="h5 mb-1 text-danger fw-bold" id="absentRecords">0</div>
                                <small class="text-muted">Absent</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Attendance Table --}}
        <div class="col-12 col-md-9">
            <div class="card shadow-lg border-0">
                
                {{-- Header with Filters --}}
                <div class="card-header bg-white py-2 py-md-3 border-bottom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <button class="btn btn-sm btn-outline-primary me-2 d-md-none" onclick="toggleClassList()">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div>
                                <h5 id="classTitle" class="mb-0 fw-bold text-dark fs-6 fs-md-5">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    Select a class to view attendance
                                </h5>
                                <small id="classSubtitle" class="text-muted">Choose a class from the left panel</small>
                            </div>
                        </div>
                        
                        {{-- Filters --}}
                        <div class="d-flex gap-1 flex-wrap w-100 w-md-auto">
                            <div class="input-group input-group-sm flex-grow-1" style="min-width: 140px;">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-calendar text-muted"></i>
                                </span>
                                <input type="date" id="filterDate" class="form-control border-start-0" onchange="applyFilters()">
                            </div>
                            
                            <div class="input-group input-group-sm flex-grow-1" style="min-width: 150px;">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="searchName" class="form-control border-start-0" placeholder="Search student..." onkeyup="applyFilters()">
                            </div>

                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-secondary d-flex align-items-center" onclick="resetFilters()">
                                    <i class="fas fa-redo d-md-none"></i>
                                    <span class="d-none d-md-inline">Reset</span>
                                </button>

                                <button class="btn btn-sm btn-outline-primary d-flex align-items-center" onclick="exportToExcel()">
                                    <i class="fas fa-download d-md-none"></i>
                                    <span class="d-none d-md-inline">Export</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile Class List Overlay --}}
                <div class="d-md-none">
                    <div id="mobileClassList" class="card border-0 bg-light mb-0" style="display: none;">
                        <div class="card-header bg-white py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Select Class</h6>
                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleClassList()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($classes as $class)
                                    <button class="list-group-item list-group-item-action d-flex align-items-center py-3 class-item-mobile"
                                        onclick="loadAttendance({{ $class->id }}, this)">
                                        <div class="class-icon me-3">
                                            <i class="fas fa-users text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 text-start">
                                            <div class="fw-semibold text-dark">{{ $class->name }}</div>
                                            <small class="text-muted">Click to view records</small>
                                        </div>
                                        <i class="fas fa-chevron-right text-muted"></i>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="card-body p-0">
                    <!-- Desktop Table View -->
                    <div class="d-none d-md-block">
                        <div class="table-responsive" style="max-height: 600px;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th class="ps-4" width="15%">
                                            <i class="fas fa-calendar me-1 text-muted"></i>Date
                                        </th>
                                        <th width="30%">
                                            <i class="fas fa-user me-1 text-muted"></i>Student
                                        </th>
                                        <th width="15%">
                                            <i class="fas fa-check-circle me-1 text-muted"></i>Status
                                        </th>
                                        <th width="40%">
                                            <i class="fas fa-comment me-1 text-muted"></i>Remarks
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="attendanceBody">
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Class Selected</h5>
                                                <p class="text-muted mb-0">Please select a class from the left panel to view attendance records</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none">
                        <div class="attendance-mobile-list" id="attendanceMobileBody">
                            <div class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Class Selected</h5>
                                    <p class="text-muted mb-0">Please select a class to view attendance records</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer with Pagination Info --}}
                <div class="card-footer bg-light py-2 py-md-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <small class="text-muted small" id="recordCount">No records loaded</small>
                        <div class="d-flex gap-2" id="paginationControls" style="display: none !important;">
                            <button class="btn btn-sm btn-outline-primary" onclick="previousPage()">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span class="mx-2 text-muted small" id="pageInfo">Page 1 of 1</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="nextPage()">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<style>
    .card {
        border-radius: 12px;
        border: none;
    }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .class-item, .class-item-mobile {
        border: none;
        border-bottom: 1px solid #f8f9fa;
        transition: all 0.3s ease;
        padding: 1rem 1.25rem;
    }

    .class-item:hover, .class-item-mobile:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
        transform: translateX(5px);
        border-left: 4px solid #667eea;
    }

    .class-item.active, .class-item-mobile.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-left: 4px solid #fff;
    }

    .class-item.active .text-dark,
    .class-item.active .text-muted,
    .class-item.active .text-primary,
    .class-item-mobile.active .text-dark,
    .class-item-mobile.active .text-muted,
    .class-item-mobile.active .text-primary {
        color: white !important;
    }

    .class-icon {
        width: 40px;
        height: 40px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stats-card {
        border-radius: 12px;
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    }

    .table th {
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        background-color: #f8f9fa;
        padding: 1rem;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transition: all 0.2s ease;
    }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-present { 
        background-color: rgba(40, 167, 69, 0.1); 
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    .status-absent { 
        background-color: rgba(220, 53, 69, 0.1); 
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
    }

    .status-late { 
        background-color: rgba(255, 193, 7, 0.1); 
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .status-excused { 
        background-color: rgba(23, 162, 184, 0.1); 
        color: #17a2b8;
        border: 1px solid rgba(23, 162, 184, 0.2);
    }

    .empty-state {
        padding: 2rem 1rem;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        min-height: 36px;
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
    }

    .form-control {
        border-radius: 0 8px 8px 0;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    /* Mobile Card Styles */
    .attendance-mobile-card {
        border-bottom: 1px solid #e9ecef;
        padding: 1rem;
        background: white;
        transition: all 0.3s ease;
    }

    .attendance-mobile-card:last-child {
        border-bottom: none;
    }

    .attendance-mobile-card:hover {
        background: #f8f9fa;
    }

    .mobile-student-avatar {
        width: 40px;
        height: 40px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
    }

    /* Mobile Optimizations */
    @media (max-width: 767.98px) {
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        h5 {
            font-size: 1.1rem;
        }
        
        h6 {
            font-size: 0.95rem;
        }
        
        .small {
            font-size: 0.8rem;
        }
        
        .btn {
            min-height: 44px; /* Touch target size */
        }
        
        .input-group {
            min-width: auto;
        }
        
        /* Mobile class list overlay */
        #mobileClassList {
            position: relative;
            z-index: 1000;
            border-radius: 0;
        }
        
        .class-item-mobile {
            padding: 0.75rem 1rem;
        }
    }

    /* Custom scrollbar */
    .table-responsive::-webkit-scrollbar {
        width: 6px;
        height: 6px;
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

    /* Loading animation */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Hide elements based on screen size */
    @media (max-width: 767.98px) {
        .d-md-block {
            display: none !important;
        }
    }

    @media (min-width: 768px) {
        .d-md-none {
            display: none !important;
        }
    }
</style>

<script>
let FULL_DATA = [];
const baseUrl = "{{ url('/') }}";
let selectedClassId = null;
let currentPage = 1;
const recordsPerPage = 10; // Reduced for mobile

function toggleClassList() {
    const classList = document.getElementById('mobileClassList');
    if (classList.style.display === 'none') {
        classList.style.display = 'block';
    } else {
        classList.style.display = 'none';
    }
}

function loadAttendance(classId, btn) {
    selectedClassId = classId;
    currentPage = 1;

    // Update UI state
    document.getElementById('classTitle').innerHTML = `
        <span class="loading-spinner me-2"></span>Loading attendance...
    `;
    document.getElementById('classSubtitle').textContent = 'Fetching records...';

    // Hide mobile class list
    document.getElementById('mobileClassList').style.display = 'none';

    // Highlight selected class
    document.querySelectorAll('.class-item, .class-item-mobile').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');

    fetch(`${baseUrl}/attendance/class/${classId}`)
    .then(res => res.json())
    .then(data => {
        FULL_DATA = data;
        renderTable(FULL_DATA);
        renderMobileCards(FULL_DATA);
        updateStats(FULL_DATA);

        if (data.length === 0) {
            document.getElementById('classTitle').innerHTML = `
                <i class="fas fa-clipboard-list me-2 text-primary"></i>No Attendance Records
            `;
            document.getElementById('classSubtitle').textContent = 'No records found for this class';
        } else {
            document.getElementById('classTitle').innerHTML = `
                <i class="fas fa-clipboard-list me-2 text-primary"></i>Attendance Records
            `;
            document.getElementById('classSubtitle').textContent = `${data.length} records found`;
        }
    })
    .catch(err => {
        console.error(err);
        document.getElementById('classTitle').innerHTML = `
            <i class="fas fa-exclamation-triangle me-2 text-danger"></i>Error Loading Data
        `;
        document.getElementById('classSubtitle').textContent = 'Please try again';
    });
}

function renderTable(rows) {
    let tbody = document.getElementById('attendanceBody');
    tbody.innerHTML = "";

    if (rows.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Records Found</h5>
                        <p class="text-muted mb-0">Try adjusting your filters or select a different class</p>
                    </div>
                </td>
            </tr>
        `;
        document.getElementById('recordCount').textContent = 'No records found';
        document.getElementById('paginationControls').style.display = 'none';
        return;
    }

    // Calculate pagination
    const startIndex = (currentPage - 1) * recordsPerPage;
    const endIndex = startIndex + recordsPerPage;
    const paginatedRows = rows.slice(startIndex, endIndex);

    paginatedRows.forEach(row => {
        const statusClass = `status-${row.status.toLowerCase()}`;
        tbody.innerHTML += `
            <tr class="fade-in">
                <td class="ps-4">
                    <div class="fw-semibold text-dark">${formatDate(row.attendance_date)}</div>
                    <small class="text-muted">${formatDay(row.attendance_date)}</small>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40 me-3">
                            <div class="symbol-label bg-light-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark">${row.student.first_name} ${row.student.last_name}</div>
                            <small class="text-muted">Student ID: ${row.student.id}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="status-badge ${statusClass}">
                        <i class="fas ${getStatusIcon(row.status)} me-1"></i>${row.status}
                    </span>
                </td>
                <td>
                    <div class="text-start">
                        ${row.remarks ? `
                            <span class="text-dark">${row.remarks}</span>
                            <br>
                            <small class="text-muted">By: ${row.marked_by || 'System'}</small>
                        ` : `
                            <span class="text-muted fst-italic">No remarks</span>
                        `}
                    </div>
                </td>
            </tr>
        `;
    });

    updatePaginationInfo(rows);
}

function renderMobileCards(rows) {
    let mobileBody = document.getElementById('attendanceMobileBody');
    mobileBody.innerHTML = "";

    if (rows.length === 0) {
        mobileBody.innerHTML = `
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Records Found</h5>
                    <p class="text-muted mb-0">Try adjusting your filters or select a different class</p>
                </div>
            </div>
        `;
        return;
    }

    // Calculate pagination for mobile
    const startIndex = (currentPage - 1) * recordsPerPage;
    const endIndex = startIndex + recordsPerPage;
    const paginatedRows = rows.slice(startIndex, endIndex);

    paginatedRows.forEach(row => {
        const statusClass = `status-${row.status.toLowerCase()}`;
        mobileBody.innerHTML += `
            <div class="attendance-mobile-card fade-in">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="mobile-student-avatar">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold text-dark">${row.student.first_name} ${row.student.last_name}</h6>
                            <small class="text-muted">ID: ${row.student.id}</small>
                        </div>
                    </div>
                    <span class="status-badge ${statusClass}">
                        <i class="fas ${getStatusIcon(row.status)} me-1"></i>${row.status}
                    </span>
                </div>
                
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <small class="text-muted d-block">Date</small>
                        <div class="fw-semibold text-dark small">${formatDate(row.attendance_date)}</div>
                        <small class="text-muted">${formatDay(row.attendance_date)}</small>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Marked By</small>
                        <div class="fw-semibold text-dark small">${row.marked_by || 'System'}</div>
                    </div>
                </div>
                
                ${row.remarks ? `
                    <div class="bg-light rounded p-2">
                        <small class="text-muted d-block mb-1">Remarks</small>
                        <div class="text-dark small">${row.remarks}</div>
                    </div>
                ` : ''}
            </div>
        `;
    });

    updatePaginationInfo(rows);
}

function updatePaginationInfo(rows) {
    const startIndex = (currentPage - 1) * recordsPerPage;
    const endIndex = startIndex + recordsPerPage;
    
    document.getElementById('recordCount').textContent = 
        `Showing ${startIndex + 1}-${Math.min(endIndex, rows.length)} of ${rows.length} records`;
    
    const totalPages = Math.ceil(rows.length / recordsPerPage);
    document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
    
    // Show/hide pagination controls
    const paginationControls = document.getElementById('paginationControls');
    if (rows.length > recordsPerPage) {
        paginationControls.style.display = 'flex !important';
    } else {
        paginationControls.style.display = 'none !important';
    }
}

function getStatusIcon(status) {
    const icons = {
        'Present': 'fa-check-circle',
        'Absent': 'fa-times-circle',
        'Late': 'fa-clock',
        'Excused': 'fa-user-clock'
    };
    return icons[status] || 'fa-circle';
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatDay(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', { weekday: 'long' });
}

function updateStats(rows) {
    const present = rows.filter(row => 
        row.status === 'Present' || row.status === 'Late' || row.status === 'Excused'
    ).length;
    const absent = rows.filter(row => row.status === 'Absent').length;

    document.getElementById('totalRecords').textContent = rows.length;
    document.getElementById('presentRecords').textContent = present;
    document.getElementById('absentRecords').textContent = absent;
}

function applyFilters() {
    let dateFilter = document.getElementById("filterDate").value;
    let searchName = document.getElementById("searchName").value.toLowerCase();

    let filtered = FULL_DATA.filter(row => {
        let matchDate = true;
        let matchSearch = true;

        if (dateFilter) {
            matchDate = row.attendance_date === dateFilter;
        }

        if (searchName) {
            let fullname = `${row.student.first_name} ${row.student.last_name}`.toLowerCase();
            matchSearch = fullname.includes(searchName);
        }

        return matchDate && matchSearch;
    });

    currentPage = 1;
    renderTable(filtered);
    renderMobileCards(filtered);
    updateStats(filtered);
}

function resetFilters() {
    document.getElementById("filterDate").value = "";
    document.getElementById("searchName").value = "";
    currentPage = 1;
    renderTable(FULL_DATA);
    renderMobileCards(FULL_DATA);
    updateStats(FULL_DATA);
}

function nextPage() {
    const totalPages = Math.ceil(FULL_DATA.length / recordsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable(FULL_DATA);
        renderMobileCards(FULL_DATA);
    }
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable(FULL_DATA);
        renderMobileCards(FULL_DATA);
    }
}

function exportToExcel() {
    if (FULL_DATA.length === 0) {
        alert('No data to export');
        return;
    }
    
    // Simple CSV export
    let csv = 'Date,Student Name,Status,Remarks,Marked By\n';
    FULL_DATA.forEach(row => {
        csv += `"${row.attendance_date}","${row.student.first_name} ${row.student.last_name}","${row.status}","${row.remarks || ''}","${row.marked_by || 'System'}"\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `attendance-${selectedClassId}-${new Date().toISOString().split('T')[0]}.csv`;
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>
@endsection