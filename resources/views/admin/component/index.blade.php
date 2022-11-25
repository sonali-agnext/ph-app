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
    <h1>Manage Scheme Component</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Manage Scheme Component</li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List of Scheme Component <a href="{{route('add-scheme-component')}}" role="button" class="btn btn-success btn-sm btn-add">Add</a></h5>
                    <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Scheme Component Type</th>
                                <th>Scheme Component</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($scheme_subcategories as $key => $scheme_category)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $scheme_category->subcategory_name}}</td>
                                <td>{{ $scheme_category->component_name}}</td>
                                <td><a href="#" role="button" data-bs-toggle="modal" data-bs-target="#viewModal{{($key+1)}}"><i class="bi bi-eye-fill"></i></a> <a href="{{route('edit-scheme-component',['id' => $scheme_category->id])}}"><i class="bi bi-pencil-square"></i></a> <a href="#" class="delete" data-id="{{$scheme_category->id}}"><i class="bi bi-trash-fill"></i></a></td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="viewModal{{($key+1)}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel">View Scheme Component</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6"><b>Scheme Component ID</b></div>
                                                <div class="col-md-6"><p>{{ $scheme_category->id}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Scheme Category Name</b></div>
                                                <div class="col-md-6"><p>{{ $scheme_category->subcategory_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Scheme Component Name</b></div>
                                                <div class="col-md-6"><p>{{ $scheme_category->component_name}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Created</b></div>
                                                <div class="col-md-6"><p>{{ $scheme_category->created_at}}</p></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"><b>Updated</b></div>
                                                <div class="col-md-6"><p>{{ $scheme_category->updated_at}}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4">No Record Found</td>
                            </tr>
                            @endforelse                    
                        </tbody>
                    </table>   
                    </div>                    
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
                        url: "{{route('delete-scheme-component')}}",
                        data: {'id':id},
                        dataType: "json",
                        success: function(resultData) { 
                            if(resultData.message == 'success'){
                                swal("Scheme Component Deleted Successfully!!", {
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
