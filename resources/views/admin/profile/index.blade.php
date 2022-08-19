@extends('layouts.admin.app')

@section('content')
<style>
    .modal-header{
        background: #457040;
        color: white;
    }
    .alert .btn-close{
        float:right;
        color: black;
        margin-top: -12px;
        margin-right: 8px;
    }
    .btn-close{
        color: white;
        background: none;
    }
    .btn-add{
        float: right;
    }
</style>
<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
      <div class="row">
        <div class="col-md-12">
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

        @if($errors->any())
        <div class="alert alert-danger alert-block"> 
            @foreach($errors->getMessages() as $this_error)
                <p><strong>{{$this_error[0]}}</strong></p>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">Close</button>
        </div>
        @endif 
        </div>
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                @php $role = \App\Models\Role::where('id', Auth::user()->role_id)->pluck('name');
                $image = \App\Models\AdminProfile::where('user_id', Auth::user()->id)->first();
                @endphp
                @if(!empty($image->avatar))
                    @if(file_exists( public_path('storage/images/admin/'.$image->avatar)))
                        <img src="{{asset('storage/images/admin/'.$image->avatar)}}" alt="Profile" class="rounded-circle">
                    @else
                    @endif
                @else
                    <img src="{{asset('img/no-user.png')}}" alt="Profile" class="rounded-circle">
                @endif
              <h2>{{Auth::user()->name}}</h2>              
              <h3>{{$role[0]}}</h3>
              <!-- <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div> -->
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">                  

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">{{Auth::user()->name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8">{{$role[0]}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{Auth::user()->email}}</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form method="POST" enctype="multipart/form-data" action="{{route('admin-profile')}}">
                    @csrf
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        @if(!empty($image->avatar))
                        
                            @if(file_exists( public_path('storage/images/admin/'.$image->avatar)))
                            <img src="{{asset('storage/images/admin/'.$image->avatar)}}" alt="Profile" class="rounded-circle">
                            @else
                            @endif
                        @else
                            <span>Upload Image</span>
                        @endif
                        <input type="file" name="avatar" id="trigger-image" style="display: none" /> 
                        <div class="pt-2">
                          <a href="#" id="upload-image" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="name" value="{{Auth::user()->name}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="{{Auth::user()->email}}">
                      </div>
                    </div>                    

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form method="POST" action="{{route('change-password')}}">
                    @csrf
                    <div class="row mb-3">
                      <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="current_password" type="password" class="form-control" id="current_password">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="new_password" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="new_password" type="password" class="form-control" id="new_password">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="new_confirm_password" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="new_confirm_password" type="password" class="form-control" id="new_confirm_password">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#example').DataTable();
        $('#upload-image').click(function(){ $('#trigger-image').trigger('click'); });
    });

</script>
@endpush
