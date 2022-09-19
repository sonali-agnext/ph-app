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
    <h1>Manage Tehsil Officer</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/manage-tehsil-officer')}}">Manage Tehsil Officer</a></li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                        <h5 class="card-title">Edit Block Officer</h5>
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
                            <form class="row g-3" method="POST" enctype="multipart/form-data" action="{{ route('add-tehsil-officer') }}">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input type="file" name="avatar" accept="image/gif, image/jpeg, image/png, image/jpg" required class="form-control" id="avatar" placeholder="Enter Avatar" value="">
                                        <label for="avatar">Avatar<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="phone_number" required class="form-control" id="mobile_number" placeholder="Enter Mobile Number" value="">
                                        <label for="mobile_number">Mobile Number<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" required class="form-control" id="name" placeholder="Enter Name" value="">
                                        <label for="name">Block Officer Name<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" required class="form-control" id="email" placeholder="Enter Email" value="">
                                        <label for="email">Email<span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" required name="state" id="state" aria-label="State">
                                            <option value="">Select State</option>                                       
                                            <option value="Punjab">Punjab</option>
                                        </select>
                                        <label for="state">State<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" required name="district_id" id="district_id" aria-label="District">
                                            <option value="">Select District</option>
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
                                        <select class="form-select" required name="tehsil_id" id="tehsil_id" aria-label="Tehsil">
                                            <option value="">Select Block</option>
                                            @forelse($tehsils as $tehsil)                                            
                                            <option value="{{ $tehsil->id }}">{{$tehsil->tehsil_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="tehsil_id">Block<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" required name="city_id" id="city_id" aria-label="City">
                                            <option value="">Select Village/City</option>
                                            @forelse($cities as $city)                                            
                                            <option value="{{ $city->id }}">{{$city->city_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="city_id">Village/City<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="address" required class="form-control" id="address" placeholder="Enter Full Address" value="">
                                        <label for="address">Full Address<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="pincode" maxlength="6" required class="form-control" id="pincode" placeholder="Enter Pin Code" value="">
                                        <label for="pincode">Pin Code<span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password" required class="form-control" id="password" placeholder="Enter Password" value="">
                                        <label for="password">Password<span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="status" id="status" aria-label="Status">
                                            <option value="1">True</option>
                                            <option value="0">False</option>
                                        </select>
                                        <label for="status">Status<span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <hr />

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="assign_tehsil_id" required id="assign_tehsil_id" aria-label="Assign Tehsil">
                                            <option value="">Assign Block</option>
                                            @forelse($tehsils as $tehsil)                                            
                                            <option value="{{ $tehsil->id }}">{{$tehsil->tehsil_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="assign_tehsil_id">Assign Block<span class="text-danger">*</span></label>
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

        $('#district_id').on('change', function(){
            var id=$(this).val();
            $.ajax({
                type: 'GET',
                url: "{{ url('/ajax-tehsil') }}",
                data: { 'district_id':id },
                dataType: "json",
                success: function(resultData) {                    
                    if(resultData.data){
                        var content= resultData.data;
                        var html ="";
                        html+='<option value="">Select Block</option>';
                        if(content.length > 0){
                            $.each(content, function (key, val) {
                                console.log(val);
                                html+='<option value="'+val.id+'">'+val.tehsil_name+'</option>';
                            });
                        }
                        $('#tehsil_id').empty();
                        $('#tehsil_id').html(html); 
                        $('#city_id').empty();
                        $('#city_id').html('<option value="">Select Village/City</option>');
                        // <option value=""></option>
                    }
                }
            });
        });

        $('#tehsil_id').on('change', function(){
            var id=$(this).val();
            $.ajax({
                type: 'GET',
                url: "{{ url('/ajax-village') }}",
                data: { 'tehsil_id':id },
                dataType: "json",
                success: function(resultData) {                    
                    if(resultData.data){
                        var content= resultData.data;
                        var html ="";
                        if(content.length > 0){
                            $.each(content, function (key, val) {
                                console.log(val);
                                html+='<option value="'+val.id+'">'+val.city_name+'</option>';
                            });
                        }else{
                            html+='<option value="">Select Village/City</option>';
                        }
                        $('#city_id').empty();
                        $('#city_id').html(html); 
                        // <option value=""></option>
                    }
                }
            });
        });
    });
</script>
@endpush