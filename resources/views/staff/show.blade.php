@extends('layouts.app')

@section('title', 'View Staff')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Staff Details - {{ucwords( $staff->first_name )}} {{ucwords( $staff->last_name )}}</h4>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    @if($staff->photo)
                        <img src="{{ucwords( asset('storage/app/public/' . $staff->photo) )}}" class="img-thumbnail rounded" width="150">
                    @else
                        <img src="https://via.placeholder.com/150" class="img-thumbnail rounded" width="150">
                    @endif
                </div>

                <div class="col-md-9">
                    <h5>Personal Information</h5>
                    <p><strong>Name:</strong> {{ucwords( $staff->first_name )}} {{ucwords( $staff->middle_name) }} {{ucwords( $staff->last_name)}}</p>
                    <p><strong>Gender:</strong> {{ucwords( $staff->gender )}}</p>
                    <p><strong>DOB:</strong> {{ucwords( $staff->dob )}}</p>
                    <p><strong>Blood Group:</strong> {{ucwords( $staff->blood_group )}}</p>
                    <p><strong>Marital Status:</strong> {{ucwords( $staff->marital_status )}}</p>
                    <p><strong>Aadhar Card</strong> {{ucwords( $staff->aadhaar_number )}}</p>
                    <p><strong>PAN Number</strong> {{ucwords( $staff->pan_number?? "-" )}}</p>

                    <hr>

                    <h5>Contact Details</h5>
                    <p><strong>Mobile:</strong> {{ucwords( $staff->mobile )}}</p>
                    <p><strong>Email:</strong> {{$staff->email }}</p>
                    <p><strong>Address:</strong> {{ucwords( $staff->address_line1 )}}, {{ucwords( $staff->city )}}, {{ucwords( $staff->state )}} - {{ucwords( $staff->pincode )}}</p>

                    <hr>

                    <h5>Employment Details</h5>
                    <p><strong>Department:</strong> {{ucwords( $staff->department )}}</p>
                    <p><strong>Designation:</strong> {{ucwords( $staff->designation )}}</p>
                    <p><strong>Joining Date:</strong> {{ucwords( $staff->joining_date )}}</p>
                    <p><strong>Role:</strong> {{ucwords( $staff->role )}}</p>

                    <hr>

                    <h5>Bank Details</h5>
                    <p><strong>Bank Name:</strong> {{ucwords( $staff->bank_name )}}</p>
                    <p><strong>Account Number:</strong> {{ucwords( $staff->account_number )}}</p>
                    <p><strong>IFSC Code:</strong> {{ucwords( $staff->ifsc_code )}}</p>

                    <hr>

                    <h5>System Access</h5>
                    <p><strong>Username:</strong> {{ucwords( $staff->username )}}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ucwords( $staff->status == 'Active' ? 'success' : 'danger' )}}">
                            {{ucwords( $staff->status )}}
                        </span>
                    </p>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ucwords( route('staff.edit', $staff->id) )}}" class="btn btn-warning px-4">Edit</a>
                <a href="{{ucwords( route('staff.index') )}}" class="btn btn-secondary px-4">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
