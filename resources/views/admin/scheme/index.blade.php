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
    <h1>Manage Scheme</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Manage Scheme</li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List of Scheme <a href="{{route('add-scheme')}}" role="button" class="btn btn-success btn-sm btn-add">Add</a></h5>
                    
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Scheme Component Type</th>
                                <th>Scheme Component</th>
                                <th>Scheme Sub Component</th>
                                <th>Scheme</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schemes as $key => $scheme)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $scheme->subcategory_name}}</td>
                                <td>{{ $scheme->component_name}}</td>
                                <td>{{ $scheme->sub_component_name}}</td>
                                <td>{{ $scheme->scheme_name}}</td>
                                <td><a href="#" role="button" data-bs-toggle="modal" data-bs-target="#viewModal{{($key+1)}}"><i class="bi bi-eye-fill"></i></a> <a href="{{route('edit-scheme',['id' => $scheme->id])}}"><i class="bi bi-pencil-square"></i></a> <a href="#" class="delete" data-id="{{$scheme->id}}"><i class="bi bi-trash-fill"></i></a></td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="viewModal{{($key+1)}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel">View Scheme</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6"><b>Scheme ID</b></div>
                                                <div class="col-md-6"><p>{{ $scheme->id }}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Scheme Component Type</b></div>
                                                <div class="col-md-6"><p>{{ $scheme->subcategory_name }}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Scheme Component</b></div>
                                                <div class="col-md-6"><p>{{ $scheme->component_name }}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Scheme Sub Component</b></div>
                                                <div class="col-md-6"><p>{{ $scheme->sub_component_type }}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Scheme Name</b></div>
                                                <div class="col-md-6"><p>{{ $scheme->scheme_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Created</b></div>
                                                <div class="col-md-6"><p>{{ $scheme->created_at}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Updated</b></div>
                                                <div class="col-md-6"><p>{{ $scheme->updated_at}}</p></div>
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
        $('#example').DataTable(
            {   

            "drawCallback": function() {

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
                        url: "{{route('delete-scheme')}}",
                        data: {'id':id},
                        dataType: "json",
                        success: function(resultData) { 
                            if(resultData.message == 'success'){
                                swal("Scheme Deleted Successfully!!", {
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
    }});
    });
</script>
@endpush
