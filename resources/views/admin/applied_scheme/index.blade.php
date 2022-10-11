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
    <h1>Manage Applied Scheme</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active">Manage Applied Scheme</li>
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
                    <h5 class="card-title">List of Manage Applied Scheme @if($role_id == 1)<a href="{{route('add-farmer')}}" role="button" class="btn btn-success btn-sm btn-add">Add</a>@endif</h5>
                    <!-- <div class="table-responsive"> -->
                    <div class="row mb-3 float-right">                        
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <select id="district_id" class="form-select form-select-sm">
                                <option value="">Search District</option>
                            @foreach($districts as $district)
                                <option value="{{$district->district_name}}">{{$district->district_name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="tehsil_id" class="form-select form-select-sm">
                                <option value="">Search Block</option>
                            @foreach($tehsils as $tehsil)
                                <option value="{{$tehsil->tehsil_name}}">{{$tehsil->tehsil_name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="tehsil_id" class="form-select form-select-sm">
                                <option value="">Search Block</option>
                            @foreach($tehsils as $tehsil)
                                <option value="{{$tehsil->tehsil_name}}">{{$tehsil->tehsil_name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="tehsil_id" class="form-select form-select-sm">
                                <option value="">Search Block</option>
                            @foreach($tehsils as $tehsil)
                                <option value="{{$tehsil->tehsil_name}}">{{$tehsil->tehsil_name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Application Number</th>
                                <th>Farmer Name</th>
                                <th>Days Left</th>
                                <th>Status</th>
                                <th>Date Applied</th>
                                <th>Block</th>
                                <th>District</th>
                                <!-- <th>Father's/Husband's Name</th> -->
                                
                                <!-- <th>City</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($farmers as $key => $farmer)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $farmer->application_number }}</td>
                                <td>{{ $farmer->name }}</td>
                                <td>{{ $farmer->tehsil_updated }}</td>
                                <td>{{ $farmer->status }}</td>
                                <td>{{ $farmer->created_at }}</td>
                                <td>{{ $farmer->tehsil_name }}</td>
                                <td>{{ $farmer->district_name }}</td>
                                
                                <!-- <td>{{ $farmer->father_husband_name}}</td> -->
                                <!-- <td>{{ $farmer->gender}}</td> -->
                                <!-- <td>{{ $farmer->city_name}}</td> -->
                                <td><a href="{{ route('view-applied-scheme',['id' => $farmer->apply_id])}}"><i class="bi bi-eye-fill"></i></a> @if($role_id == 1)<a href="{{route('edit-farmer',['id' => $farmer->id])}}"><i class="bi bi-pencil-square"></i></a> <a href="#" class="delete" data-id="{{$farmer->id}}"><i class="bi bi-trash-fill"></i></a>@endif</td>
                            </tr>
                            
                            @empty
                            <tr>
                                <td colspan="7">No Record Found</td>
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
        var table = $('#example').DataTable(
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
            }
        });
        $('#district_id').on('change', function () {
            table.columns(5).search( this.value ).draw();
        } );

        $('#tehsil_id').on('change', function () {
            table.columns(4).search( this.value ).draw();
        } );
    });
</script>
@endpush
