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
    <h1>Manage Block</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Manage Block</li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List of Block <a href="{{route('add-tehsil')}}" role="button" class="btn btn-success btn-sm btn-add">Add</a></h5>
                    
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>District Name</th>
                                <th>Block</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tehsils as $key => $tehsil)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $tehsil->district_name}}</td>
                                <td>{{ $tehsil->tehsil_name}}</td>
                                <td><a href="#" role="button" data-bs-toggle="modal" data-bs-target="#viewModal{{($key+1)}}"><i class="bi bi-eye-fill"></i></a> <a href="{{route('edit-block',['id' => $tehsil->id])}}"><i class="bi bi-pencil-square"></i></a> <a href="#" class="delete" data-id="{{$tehsil->id}}"><i class="bi bi-trash-fill"></i></a></td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="viewModal{{($key+1)}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel">View Block</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6"><b>Block ID</b></div>
                                                <div class="col-md-6"><p>{{ $tehsil->id}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>District Name</b></div>
                                                <div class="col-md-6"><p>{{ $tehsil->district_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Block Name</b></div>
                                                <div class="col-md-6"><p>{{ $tehsil->tehsil_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Created</b></div>
                                                <div class="col-md-6"><p>{{ $tehsil->created_at}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Updated</b></div>
                                                <div class="col-md-6"><p>{{ $tehsil->updated_at}}</p></div>
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
                        url: "{{route('delete-tehsil')}}",
                        data: {'id':id},
                        dataType: "json",
                        success: function(resultData) { 
                            if(resultData.message == 'success'){
                                swal("Block Deleted Successfully!!", {
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
