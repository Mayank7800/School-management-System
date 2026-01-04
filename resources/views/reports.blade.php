@extends('layouts.app')

@section('title', 'Syllabus Management')
@section('page_title', 'Syllabus Management')

@section('content')

    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #e0e7ff;
            --primary-dark: #4338ca;
            --secondary: #64748b;
            --success: #10b981;
            --success-light: #d1fae5;
            --info: #06b6d4;
            --info-light: #cffafe;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --dark: #1e293b;
            --light: #f8fafc;
            --border-radius: 16px;
            --border-radius-sm: 8px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --box-shadow-hover: 0 10px 30px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #f8fafc 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Page Header */
        .page-header {
            padding: 2rem 0 1.5rem;
            position: relative;
        }

        .page-header h1 {
            font-size: 2.2rem;
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .page-header h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 4px;
        }

        .page-header p {
            font-size: 1.1rem;
            color: var(--secondary);
            max-width: 600px;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
        }

        /* Reports Grid */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .report-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.75rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .report-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
        }

        .report-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--box-shadow-hover);
        }

        .card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-light);
            flex-shrink: 0;
            margin-left: 1rem;
        }

        .card-icon i {
            font-size: 1.75rem;
            color: var(--primary);
        }

        .card-content {
            flex: 1;
        }

        .table-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .table-name .badge {
            margin-left: 0.75rem;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        .card-description {
            color: var(--secondary);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .card-footer {
            margin-top: auto;
        }

        .btn-download {
            background: var(--success);
            border-color: var(--success);
            color: white;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .btn-download:hover {
            background: #0da271;
            border-color: #0da271;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .btn-download i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        .btn-back {
            background: white;
            border: 1px solid #e2e8f0;
            color: var(--dark);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            color: var(--dark);
            text-decoration: none;
        }

        .btn-back i {
            margin-right: 6px;
        }

        /* Info Alert */
        .info-card {
            background: var(--info-light);
            border: 1px solid rgba(6, 182, 212, 0.2);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--info);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .info-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .info-content h5 {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .info-content p {
            color: var(--secondary);
            margin-bottom: 0;
        }

        /* Animation for cards on load */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .report-card {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .report-card:nth-child(1) { animation-delay: 0.1s; }
        .report-card:nth-child(2) { animation-delay: 0.2s; }
        .report-card:nth-child(3) { animation-delay: 0.3s; }
        .report-card:nth-child(4) { animation-delay: 0.4s; }
        .report-card:nth-child(5) { animation-delay: 0.5s; }
        .report-card:nth-child(6) { animation-delay: 0.6s; }

        /* Responsive Design */
        @media (max-width: 992px) {
            .reports-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 1.8rem;
            }

            .reports-grid {
                grid-template-columns: 1fr;
            }

            .report-card {
                padding: 1.5rem;
            }

            .card-header {
                flex-direction: column;
            }

            .card-icon {
                margin-left: 0;
                margin-top: 1rem;
                align-self: flex-start;
            }
        }

        @media (max-width: 576px) {
            .page-header h1 {
                font-size: 1.6rem;
            }

            .report-card {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h1>📊 Database Reports</h1>
                <p>Export your data as CSV files for analysis and backup</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <!-- Reports Grid -->
        <div class="reports-grid">
            <!-- Student Admissions Card -->
            <div class="report-card">
                <div class="card-header">
                    <div class="card-content">
                        <div class="table-name">
                            Students
                            <span class="badge bg-primary">Table</span>
                        </div>
                        <p class="card-description">List of all registered students with personal details, enrollment information, and academic records.</p>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.export', 'student_admissions') }}" class="btn btn-download">
                        <i class="bi bi-download"></i> Download CSV Report
                    </a>
                </div>
            </div>

            <!-- Staff Card -->
            <div class="report-card">
                <div class="card-header">
                    <div class="card-content">
                        <div class="table-name">
                            Staff
                            <span class="badge bg-primary">Table</span>
                        </div>
                        <p class="card-description">All staff members and teaching faculty records including roles, departments, and contact information.</p>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.export', 'staff') }}" class="btn btn-download">
                        <i class="bi bi-download"></i> Download CSV Report
                    </a>
                </div>
            </div>

            <!-- Student Fees Card -->
            <div class="report-card">
                <div class="card-header">
                    <div class="card-content">
                        <div class="table-name">
                            Student Fees
                            <span class="badge bg-primary">Table</span>
                        </div>
                        <p class="card-description">Student fee structures, payable amounts, due dates, and financial information for each academic term.</p>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.export', 'student_fees') }}" class="btn btn-download">
                        <i class="bi bi-download"></i> Download CSV Report
                    </a>
                </div>
            </div>

            <!-- Fee Payments Card -->
            <div class="report-card">
                <div class="card-header">
                    <div class="card-content">
                        <div class="table-name">
                            Fee Payments
                            <span class="badge bg-primary">Table</span>
                        </div>
                        <p class="card-description">Records of all student fee payments with payment modes, transaction details, dates, and status.</p>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.export', 'fee_payments') }}" class="btn btn-download">
                        <i class="bi bi-download"></i> Download CSV Report
                    </a>
                </div>
            </div>

            <!-- Courses Card -->
            <div class="report-card">
                <div class="card-header">
                    <div class="card-content">
                        <div class="table-name">
                            Courses
                            <span class="badge bg-primary">Table</span>
                        </div>
                        <p class="card-description">List of all available courses under each college/branch with duration, fees, and curriculum details.</p>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.export', 'courses') }}" class="btn btn-download">
                        <i class="bi bi-download"></i> Download CSV Report
                    </a>
                </div>
            </div>

            <!-- Branches Card -->
            <div class="report-card">
                <div class="card-header">
                    <div class="card-content">
                        <div class="table-name">
                            Branches
                            <span class="badge bg-primary">Table</span>
                        </div>
                        <p class="card-description">Branch details for different courses or colleges including locations, contacts, and facilities.</p>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('reports.export', 'branches') }}" class="btn btn-download">
                        <i class="bi bi-download"></i> Download CSV Report
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-circle"></i>
            </div>
            <div class="info-content">
                <h5>Export Information</h5>
                <p>The system automatically includes all table columns and exports them in <strong>UTF-8 CSV format</strong>. Files are generated in real-time with the latest data from your database.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
</body>
</html>
@endsection
