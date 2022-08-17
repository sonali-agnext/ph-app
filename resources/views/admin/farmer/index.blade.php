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
</style>
<div class="pagetitle">
    <h1>Manage Farmer</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                    <h5 class="card-title">List of Farmers <a href="{{route('add-farmer')}}" role="button" class="btn btn-success btn-sm btn-add">Add</a></h5>
                    <!-- <div class="table-responsive"> -->
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Avatar</th>
                                <th>Applicant Type</th>
                                <th>Farmer Name</th>
                                <th>Mobile Number</th>
                                <!-- <th>Father's/Husband's Name</th> -->
                                
                                <!-- <th>City</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($farmers as $key => $farmer)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td><img src="{{ asset('storage/images/'.$farmer->avatar)}}" width="50" height="50"/></td>
                                
                                <td>{{ $farmer->applicant_type_name	}}</td>
                                <td>{{ $farmer->name}}</td>
                                <td>{{ $farmer->mobile_number}}</td>
                                
                                <!-- <td>{{ $farmer->father_husband_name}}</td> -->
                                <!-- <td>{{ $farmer->gender}}</td> -->
                                <!-- <td>{{ $farmer->city_name}}</td> -->
                                <td><a href="#" role="button" data-bs-toggle="modal" data-bs-target="#viewModal{{($key+1)}}"><i class="bi bi-eye-fill"></i></a> <a href="{{route('edit-farmer',['id' => $farmer->id])}}"><i class="bi bi-pencil-square"></i></a> <a href="#" class="delete" data-id="{{$farmer->id}}"><i class="bi bi-trash-fill"></i></a></td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="viewModal{{($key+1)}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel">View Farmer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6"><b>Farmer ID</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->farmer_unique_id}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Applicant Type</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->applicant_type_name	}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Farmer Name</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Mobile Number</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->mobile_number}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Father's/Husband's Name</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->father_husband_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Gender</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->gender}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Resident</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->resident}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Aadhar No.</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->aadhar_number}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Pan No.</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->pan_number}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Full Address</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->full_address}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>City</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->city_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>District</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->district_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>State</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->state}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Pin Code</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->pin_code}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Created</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->created_at}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Updated</b></div>
                                                <div class="col-md-6"><p>{{ $farmer->updated_at}}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="3">No Record Found</td>
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
        $('#example').DataTable();

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
                        url: "{{route('delete-farmer')}}",
                        data: {'id':id},
                        dataType: "json",
                        success: function(resultData) { 
                            if(resultData.message == 'success'){
                                swal("Farmer Deleted Successfully!!", {
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
