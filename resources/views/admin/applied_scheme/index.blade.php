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
    .badge-pill{
        border-radius: 12px;
        padding: 7px 15px;
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
                    <h5 class="card-title">List of Manage Applied Scheme</h5>
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
                                <option value="">Search Status</option>
                            @foreach($tehsils as $tehsil)
                                <option value="{{$tehsil->tehsil_name}}">{{$tehsil->tehsil_name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="tehsil_id" class="form-select form-select-sm">
                                <option value="">Search Day/Monthwise</option>                            
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
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
                                <th>Stage</th>
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
                                <td>@if($role_id == 5 && $farmer->stage != 'Tehsil')
                                    --
                                    @elseif($role_id == 4 && $farmer->stage != 'Committee' )
                                    --
                                    @elseif($farmer->stage == 'State')
                                    --
                                    @else
                                        @if($farmer->stage == 'Tehsil' && !empty($farmer->tehsil_updated)  && ($farmer->applied_status == "Resubmit" || $farmer->applied_status == "Auto Approved"))
                                        @php
                                            $date1= date('Y-m-d',strtotime($farmer->tehsil_updated.'+7 day'));
                                            $date2= date('Y-m-d');
                                            $date11 = date_create($date1);
                                            $date22 = date_create($date2);

                                            $dateDifference = date_diff($date11, $date22)->format('%d');
                                            
                                        @endphp
                                        @if($dateDifference == 1)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F47564 !important;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 2)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F6A69B !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 3)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F8C699 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 4)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #FBDDC2 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 5)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #C4FFE6 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 6)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #DDFFF1 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 7)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #fff !important; border: 1px solid #222222 !important; color:#000;">{{$dateDifference}}</span>
                                        @endif
                                        @endif
                                        

                                        @if($farmer->stage == 'Tehsil' && empty($farmer->tehsil_updated) && ($farmer->applied_status == "Resubmit") || $farmer->applied_status == "In Progress")
                                        @php
                                            $date1= date('Y-m-d',strtotime($farmer->aupdated_at.'+7 day'));
                                            $date2= date('Y-m-d');
                                            $date11 = date_create($date1);
                                            $date22 = date_create($date2);

                                            $dateDifference = date_diff($date11, $date22)->format('%d');
                                        @endphp 
                                        @if($dateDifference == 1)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F47564 !important;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 2)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F6A69B !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 3)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F8C699 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 4)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #FBDDC2 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 5)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #C4FFE6 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 6)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #DDFFF1 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 7)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #fff !important; border: 1px solid #222222 !important; color:#000;">{{$dateDifference}}</span>
                                        @endif
                                        @endif
                                        
                                        @if($farmer->stage == 'District' && empty($farmer->district_updated) && $farmer->district_status == "In Progress")
                                        @php
                                            $date1= date('Y-m-d',strtotime($farmer->tehsil_updated.'+7 day'));
                                            $date2= date('Y-m-d');
                                            $date11 = date_create($date1);
                                            $date22 = date_create($date2);

                                            $dateDifference = date_diff($date11, $date22)->format('%d');
                                        @endphp 
                                        @if($dateDifference == 1)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F47564 !important;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 2)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F6A69B !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 3)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #F8C699 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 4)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #FBDDC2 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 5)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #C4FFE6 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 6)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #DDFFF1 !important; color:#000;">{{$dateDifference}}</span>
                                        @elseif($dateDifference == 7)
                                        <span class="badge bg-primary badge-pill badge-number" style="background: #fff !important; border: 1px solid #222222 !important; color:#000;">{{$dateDifference}}</span>
                                        @endif
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $farmer->applied_status }}</td>
                                <td>{{ date('d-m-Y',strtotime($farmer->acreated_at)) }}</td>
                                <td>{{ $farmer->tehsil_name }}</td>
                                <td>{{ $farmer->district_name }}</td>
                                <td>{{ $farmer->stage }}</td>
                                <td><a href="{{ route('view-applied-scheme',['id' => $farmer->apply_id])}}"><i class="bi bi-eye-fill"></i></a> </td>
                            </tr>
                            
                            @empty
                            <tr>
                                <td colspan="10">No Record Found</td>
                            </tr>
                            @endforelse                    
                        </tbody>
                    </table>
                    <!-- </div>                      -->
                </div>
            </div>     
        </div><!--https://youtu.be/C2iWTFToMOg
https://youtu.be/61pqsIRc_6E End Left side columns -->

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
