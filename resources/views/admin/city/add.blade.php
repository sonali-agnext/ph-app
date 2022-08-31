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
    <h1>Manage Village/City</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/manage-city')}}">Manage Village/City</a></li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                        <h5 class="card-title">Add Village/City</h5>
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
                            <form class="row g-3" method="POST" action="{{ route('add-city') }}">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="tehsil_id" id="tehsil_id" aria-label="Tehsil">
                                            @forelse($tehsil as $dst)                                            
                                            <option value="{{ $dst->id }}">{{$dst->tehsil_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="tehsil_id">Block</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" name="city_name" required class="form-control" id="city_name" placeholder="Enter City" value="">
                                        <label for="city_name">Village/City Name</label>
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
