@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4 text-center">Student Admission Details</h4>

    <div class="card shadow-sm mb-4 p-4">
        {{-- Personal Details --}}
        <h5 class="mb-3">Personal Details</h5>
        <div class="row g-3">
            <div class="col-md-4"><strong>First Name:</strong> {{ $student->first_name }}</div>
            <div class="col-md-4"><strong>Middle Name:</strong> {{ $student->middle_name ?? '-' }}</div>
            <div class="col-md-4"><strong>Last Name:</strong> {{ $student->last_name }}</div>
            <div class="col-md-3"><strong>Gender:</strong> {{ $student->gender }}</div>
            <div class="col-md-3"><strong>Date of Birth:</strong> {{ $student->date_of_birth }}</div>
            <div class="col-md-3"><strong>Blood Group:</strong> {{ $student->blood_group ?? '-' }}</div>
            <div class="col-md-3"><strong>Nationality:</strong> {{ $student->nationality ?? '-' }}</div>
        </div>
    </div>

    <div class="card shadow-sm mb-4 p-4">
        {{-- Contact & Address --}}
        <h5 class="mb-3">Contact & Address</h5>
        <div class="row g-3">
            <div class="col-md-4"><strong>Mobile No:</strong> {{ $student->mobile_no }}</div>
            <div class="col-md-4"><strong>Alternate Mobile:</strong> {{ $student->alt_mobile_no ?? '-' }}</div>
            <div class="col-md-4"><strong>Email:</strong> {{ $student->email ?? '-' }}</div>
            <div class="col-md-6"><strong>Address Line 1:</strong> {{ $student->address_line1 }}</div>
            <div class="col-md-6"><strong>Address Line 2:</strong> {{ $student->address_line2 ?? '-' }}</div>
            <div class="col-md-3"><strong>City:</strong> {{ $student->city ?? '-' }}</div>
            <div class="col-md-3"><strong>State:</strong> {{ $student->state ?? '-' }}</div>
            <div class="col-md-3"><strong>Pincode:</strong> {{ $student->pincode ?? '-' }}</div>
            <div class="col-md-3"><strong>Country:</strong> {{ $student->country ?? '-' }}</div>
        </div>
    </div>

    <div class="card shadow-sm mb-4 p-4">
        {{-- Parents & Guardian --}}
        <h5 class="mb-3">Parents & Guardian</h5>
        <div class="row g-3">
            <div class="col-md-4"><strong>Father's Name:</strong> {{ $student->father_name ?? '-' }}</div>
            <div class="col-md-4"><strong>Occupation:</strong> {{ $student->father_occupation ?? '-' }}</div>
            <div class="col-md-4"><strong>Contact:</strong> {{ $student->father_contact ?? '-' }}</div>
            <div class="col-md-4"><strong>Mother's Name:</strong> {{ $student->mother_name ?? '-' }}</div>
            <div class="col-md-4"><strong>Occupation:</strong> {{ $student->mother_occupation ?? '-' }}</div>
            <div class="col-md-4"><strong>Contact:</strong> {{ $student->mother_contact ?? '-' }}</div>
            <div class="col-md-4"><strong>Guardian Name:</strong> {{ $student->guardian_name ?? '-' }}</div>
            <div class="col-md-4"><strong>Relation:</strong> {{ $student->guardian_relation ?? '-' }}</div>
            <div class="col-md-4"><strong>Contact:</strong> {{ $student->guardian_contact ?? '-' }}</div>
        </div>
    </div>

    <div class="card shadow-sm mb-4 p-4">
        {{-- Admission & Fees --}}
        <h5 class="mb-3">Admission Details</h5>
        <div class="row g-3">
            <div class="col-md-3"><strong>Admission No:</strong> {{ $student->admission_no }}</div>
            <div class="col-md-3"><strong>Admission Date:</strong> {{ $student->admission_date }}</div>
            <div class="col-md-3"><strong>Academic Year:</strong> {{ $student->academic_year ?? '-' }}</div>
            <div class="col-md-3"><strong>Class:</strong> {{ $student->class ?? '-' }}</div>
            <div class="col-md-3"><strong>Section:</strong> {{ $student->section ?? '-' }}</div>
            <div class="col-md-3"><strong>Roll No:</strong> {{ $student->roll_no ?? '-' }}</div>
            <div class="col-md-3"><strong>Admission Fee:</strong> {{ $student->admission_fee ?? '-' }}</div>
            <div class="col-md-3"><strong>Tuition Fee:</strong> {{ $student->tuition_fee ?? '-' }}</div>
            <div class="col-md-4"><strong>Payment Mode:</strong> {{ $student->payment_mode ?? '-' }}</div>
            <div class="col-md-4"><strong>Transaction ID:</strong> {{ $student->transaction_id ?? '-' }}</div>
            <div class="col-md-4">
                <strong>Fee Receipt:</strong>
                @if($student->fee_receipt)
                    <a href="{{ asset('storage/' . $student->fee_receipt) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                @else
                    -
                @endif
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4 p-4">
        {{-- Documents & Status --}}
        <h5 class="mb-3">Documents & Status</h5>
        <div class="row g-3">
            @php
                $docs = ['student_photo','birth_certificate','id_proof','marksheet','caste_certificate','transfer_certificate'];
            @endphp
            @foreach($docs as $doc)
                <div class="col-md-4">
                    <strong>{{ ucwords(str_replace('_',' ',$doc)) }}:</strong>
                    @if($student->$doc)
                        <a href="{{ asset('storage/' . $student->$doc) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                    @else
                        -
                    @endif
                </div>
            @endforeach

            <div class="col-md-12 mt-3"><strong>Remarks:</strong> {{ $student->remarks ?? '-' }}</div>
            <div class="col-md-4 mt-2"><strong>Status:</strong> {{ $student->status }}</div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('admissions.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
