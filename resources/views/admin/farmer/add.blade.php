@extends('layouts.admin.app')

@section('content')
<style>
    .modal-header{
        background: #457040;
        color: white;
    }
    .btn-close{
        color: black;
        background: none;
        float:right;
    }
</style>
<div class="pagetitle">
    <h1>Manage Farmer</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Farmer</a></li>
        <li class="breadcrumb-item active">Manage Farmer</li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                        <h5 class="card-title">Add Farmer</h5>
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">                            
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
                        </div>
                        @endif
                        
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">   
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
                        </div>
                        @endif
                            <!-- Floating Labels Form -->
                            <form class="row g-3" method="POST" enctype="multipart/form-data" action="{{ route('add-farmer') }}">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="file" name="avatar" accept="image/gif, image/jpeg, image/png, image/jpg" required class="form-control" id="avatar" placeholder="Enter Avatar" value="">
                                        <label for="avatar">Avatar<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="mobile_number" required class="form-control" id="mobile_number" placeholder="Enter Mobile Number" value="">
                                        <label for="mobile_number">Mobile Number<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" required class="form-control" id="name" placeholder="Enter Name" value="">
                                        <label for="name">Farmer Name<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="language" id="language" aria-label="Language">                                       
                                            <option value="en">English</option>
                                            <option value="hi">Hindi</option>
                                            <option value="pb">Punjabi</option>
                                        </select>
                                        <label for="language">Language<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="applicant_type_id" id="applicant_type_id" aria-label="Applicant Type">
                                            @forelse($applicant_types as $applicant_type)                                            
                                            <option value="{{ $applicant_type->id }}">{{$applicant_type->applicant_type_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="applicant_type_id">Applicant Type<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="father_husband_name" required class="form-control" id="father_husband_name" placeholder="Enter Father's/ Husband's Name" value="">
                                        <label for="father_husband_name">Father's/ Husband's Name<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="gender" id="gender" aria-label="Gender">                                       
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        <label for="gender">Gender<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="resident" id="resident" aria-label="Resident">                                       
                                            <option value="Indian">Indian</option>
                                        </select>
                                        <label for="resident">Resident<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="aadhar_number" maxlength="12" required class="form-control" id="aadhar_number" placeholder="Enter Father's/ Husband's Name" value="">
                                        <label for="aadhar_number">Aadhar Number<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="pan_number" maxlength="10" required class="form-control" id="pan_number" placeholder="Enter Father's/ Husband's Name" value="">
                                        <label for="pan_number">PAN Number<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="caste_category_id" id="caste_category_id" aria-label="Caste Category">
                                            @forelse($caste_categories as $caste_category)                                            
                                            <option value="{{ $caste_category->id }}">{{$caste_category->caste_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="caste_category_id">Caste Category<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="state" id="state" aria-label="State">                                       
                                            <option value="Punjab">Punjab</option>
                                        </select>
                                        <label for="state">State<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="district_id" id="district_id" aria-label="District">
                                            @forelse($districts as $district)                                            
                                            <option value="{{ $district->id }}">{{$district->district_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="district_id">District<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="tehsil_id" id="tehsil_id" aria-label="Tehsil">
                                            @forelse($tehsils as $tehsil)                                            
                                            <option value="{{ $tehsil->id }}">{{$tehsil->tehsil_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="tehsil_id">Tehsil<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="city_id" id="city_id" aria-label="City">
                                            @forelse($cities as $city)                                            
                                            <option value="{{ $city->id }}">{{$city->city_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="city_id">City<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="full_address" required class="form-control" id="full_address" placeholder="Enter Full Address" value="">
                                        <label for="full_address">Full Address<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="pin_code" maxlength="6" required class="form-control" id="pin_code" placeholder="Enter Pin Code" value="">
                                        <label for="pin_code">Pin Code<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                                </div>
                            </form><!-- End floating Labels Form -->
                                       
                </div>
            </div>     
        </div><!-- End Left side columns -->

    </div>


</section>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endpush
