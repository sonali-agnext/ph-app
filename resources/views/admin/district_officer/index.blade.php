@extends('layouts.admin.app')

@section('content')
<style>
    .modal-header{
        background: #457040;
        color: white;
    }
    .btn-close{
        color: white;
        background: none;
    }
    .btn-add{
        float: right;
    }
    #example_filter label{
        float: right;
    }
</style>
<div class="pagetitle">
    <h1>Manage District Officer</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Manage District Officer</li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
    @php
        $districts = App\Models\District::all();
        $tehsils = App\Models\Tehsil::all();
        $role_id = Auth::user()->role_id;
    @endphp
        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">  
                <h5 class="card-title">List of District Officers @if($role_id == 1)<a href="{{route('add-district-officer')}}" role="button" class="btn btn-success btn-sm btn-add">Add</a>@endif</h5>                  
                    <!-- <div class="table-responsive"> -->
                    <div class="row mb-3 float-right">
                        @inject('district', 'App\Models\District')
                    </div>
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Avatar</th>
                                <th>Assigned District</th>
                                <th>Officer Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($states as $key => $state)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td><img src="{{ asset('storage/images/'.$state->avatar)}}" width="50" height="50"/></td>
                                <td>{{ $district->getDistrictName($state->district_officer_id)}}</td>
                                <td>{{ $state->name }}</td>
                                <td>{{ $state->email}}</td>
                                <td>{{ $state->phone_number}}</td>
                                <td><a href="#" role="button" data-bs-toggle="modal" data-bs-target="#viewModal{{($key+1)}}"><i class="bi bi-eye-fill"></i></a> @if($role_id == 1)<a href="{{route('edit-district-officer',['id' => $state->id])}}"><i class="bi bi-pencil-square"></i></a> <a href="#" class="delete" data-id="{{$state->id}}"><i class="bi bi-trash-fill"></i></a>@endif</td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="viewModal{{($key+1)}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel">View District</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6"><b>Officer ID</b></div>
                                                <div class="col-md-6"><p>{{ $state->id}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Officer Name</b></div>
                                                <div class="col-md-6"><p>{{ $state->name }}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Email</b></div>
                                                <div class="col-md-6"><p>{{ $state->email}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Mobile Number</b></div>
                                                <div class="col-md-6"><p>{{ $state->phone_number}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Full Address</b></div>
                                                <div class="col-md-6"><p>{{ $state->address}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>City</b></div>
                                                <div class="col-md-6"><p>{{ $state->city_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>District</b></div>
                                                <div class="col-md-6"><p>{{ $state->district_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>State</b></div>
                                                <div class="col-md-6"><p>{{ $state->state}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Pin Code</b></div>
                                                <div class="col-md-6"><p>{{ $state->pincode}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Assigned to District</b></div>
                                                <div class="col-md-6"><p>{{ $district->getDistrictName($state->district_officer_id)}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Created</b></div>
                                                <div class="col-md-6"><p>{{ $state->created_at}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Updated</b></div>
                                                <div class="col-md-6"><p>{{ $state->updated_at}}</p></div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6">No Record Found</td>
                            </tr>
                            @endforelse                    
                        </tbody>
                    </table>
                    <!-- </div>                      -->
                </div>
            </div>     
        </div><!-- End Left side columns -->

    </div>


</section>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        var table = $('#example').DataTable();
        $('#district_id').on('change', function () {
            table.columns(5).search( this.value ).draw();
        } );

        $('#tehsil_id').on('change', function () {
            table.columns(4).search( this.value ).draw();
        } );

        $('.delete').on('click', function(){
            var id=$(this).attr("data-id");
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var saveData = $.ajax({
                        type: 'POST',
                        url: "{{route('delete-district-officer')}}",
                        data: {'id':id},
                        dataType: "json",
                        success: function(resultData) { 
                            if(resultData.message == 'success'){
                                swal("District Officer Deleted Successfully!!", {
                                    icon: "success",
                                });
                                location.reload();
                            }else{
                                swal("Something Went Wrong!!", {
                                    icon: "error",
                                });
                            }
                         }
                    });
                    
                } else {
                }
            });
        });
    });
</script>
@endpush
