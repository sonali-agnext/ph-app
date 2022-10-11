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
    .nested .card-p{
        border: 3px solid #727272;
        border-radius: 16px;
        padding: 10px;
    }
    .nested .card-title{
        font-size: 15px;
        padding: 0px;
        color: #000;
    }
    .inform .card-title{
        font-size: 15px;
        padding: 0px;
        color: #000;
    }
    .jumbotron {
        padding: 15px;
        margin-bottom: 2rem;
        background-color: #e9ecef;
        border-radius: 0.3rem;
    }
    .modal-dialog{
        max-width: 50%;
    }
</style>
<div class="pagetitle">
    <h1>View Farmer Application</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active">View Farmer Application Detail</li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
    <?php 
        $districts = App\Models\FarmerLandDetail::select('farmer_land_details.*', 'districts.district_name', 'tehsils.tehsil_name','cities.city_name')->join('cities','farmer_land_details.city_id','=','cities.id')->join('districts','farmer_land_details.district_id','=','districts.id')->join('tehsils','farmer_land_details.tehsil_id','=','tehsils.id')->where('farmer_id', $farmers->farmer_id)->get();

    ?>
        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Farmer Application Details</h5>
                    <p></p>
                    <!-- <div class="table-responsive"> -->
                    <div class="row mb-3 float-right">
                        
                        <div class="col-md-12">
                            <div class="nested card-body">
                                <h6 class="card-title">Your Remarks</h6> 
                                <p class="card-p">Ut in ea error laudantium quas omnis officia. Sit sed praesentium voluptas. Corrupti inventore consequatur nisi necessitatibus modi consequuntur soluta id. Enim autem est esse natus assumenda. Non sunt dignissimos officiis expedita. Consequatur sint repellendus voluptas. Quidem sit est nulla ullam. Suscipit debitis ullam iusto dolorem animi dolorem numquam. Enim fuga ipsum dolor nulla quia ut. Rerum dolor voluptatem et deleniti libero totam numquam nobis distinctio. Sit sint aut. Consequatur rerum in.</p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="inform card-body">
                                <h6 class="card-title">Farmer Information</h6>                               
                            </div>
                        
                            <div class="col-md-12 card-body">
                                @if(!empty($farmers->avatar))
                                <img src="{{asset('/storage/images/'.$farmers->avatar)}}" class="mb-3" style="border-radius:100%" width="92" height="92"/>
                                @endif 
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="name" class="form-control" disabled value="{{ $farmers->name }}">
                                            <label for="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="farmer_id" class="form-control" disabled value="{{ $farmers->farmer_unique_id }}">
                                            <label for="farmer_id">Farmer Unique ID</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="jumbotron">
                                            <h5>Personal Information</h5>
                                            <a href="#" class="btn btn-md btn-info" role="button" data-bs-toggle="modal" data-bs-target="#viewModal{{($farmers->id)}}">See all</a>
                                            <div class="modal fade" id="viewModal{{($farmers->id)}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewModalLabel">Farmer Personal Information</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Applicant Type</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->applicant_type_name	}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Farmer Name</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Mobile Number</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->mobile_number}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Father's/Husband's Name</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->father_husband_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Gender</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->gender}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Resident</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->resident}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Aadhar No.</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->aadhar_number}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Pan No.</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->pan_number}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Full Address</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->full_address}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>City</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->city_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Block</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->tehsil_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>District</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->district_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>State</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->state}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Pin Code</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->pin_code}}</p></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="jumbotron">
                                            <h5>Farmer Address</h5>
                                            <a href="#" class="btn btn-md btn-info" role="button" data-bs-toggle="modal" data-bs-target="#viewModals{{($farmers->id)}}">See all</a>
                                            <div class="modal fade" id="viewModals{{($farmers->id)}}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewModalLabel">Farmer Personal Information</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Full Address</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->full_address}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>City</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->city_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Block</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->tehsil_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>District</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->district_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>State</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->state}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Pin Code</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->pin_code}}</p></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end farmer information -->
                        <div class="col-md-12">
                            <div class="inform card-body">
                                <h6 class="card-title">Scheme Information</h6>                               
                            </div>
                        
                            <div class="col-md-12 card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" name="c" class="form-control" disabled value="{{ $farmers->scheme_name }}">
                                            <label for="sector">Scheme Applied</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="sector" class="form-control" disabled value="{{ empty($farmers->public_private)? 'Public' :'Private' }}">
                                            <label for="sector">Sector</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="application_number" class="form-control" disabled value="{{ $farmers->application_number }}">
                                            <label for="application_number">Application Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end scheme information -->

                        <div class="col-md-12 mt-4">
                            <div class="inform card-body">
                                <h6 class="card-title">Document Information</h6>                               
                            </div>
                        
                            <div class="col-md-12 card-body"> 
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="jumbotron">
                                            <h5>Land Details</h5>
                                            <a href="#" class="btn btn-md btn-info" role="button" data-bs-toggle="modal" data-bs-target="#viewLand{{($farmers->id)}}">See all</a>
                                            <div class="modal fade" id="viewLand{{($farmers->id)}}" tabindex="-1" aria-labelledby="viewLandLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewLandLabel">Land Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            
                                                            @foreach($districts as $key => $land)
                                                            <h4><b>Land Address{{ ($key+1) }}</b></h4>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Total Land(Hectare)</b></div>
                                                                <div class="col-md-6"><p>{{ $land->total_land_area	}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Area Information</b></div>
                                                                <div class="col-md-6"><p>{{ $land->area_information}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Land Address</b></div>
                                                                <div class="col-md-6"><p>{{ $land->land_address}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Land City</b></div>
                                                                <div class="col-md-6"><p>{{ $land->city_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Land Block</b></div>
                                                                <div class="col-md-6"><p>{{ $land->tehsil_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Land District</b></div>
                                                                <div class="col-md-6"><p>{{ $land->district_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Land State</b></div>
                                                                <div class="col-md-6"><p>{{ $land->state}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Land Pin Code</b></div>
                                                                <div class="col-md-6"><p>{{ $land->pin_code}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Khewat No.</b></div>
                                                                <div class="col-md-6"><p>{{ $land->khewat_no}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Khasra No.</b></div>
                                                                <div class="col-md-6"><p>{{ $land->khasra_no}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Khatauni No.</b></div>
                                                                <div class="col-md-6"><p>{{ $land->khatauni_no}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Upload Fard</b></div>
                                                                <div class="col-md-6"><a href="{{url('/storage/land-images/'. $land->upload_fard)}}" print>{{ $land->upload_fard}}</a></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Upload Pattedar</b></div>
                                                                <div class="col-md-6"><a href="{{url('/storage/land-images/'. $land->upload_pattedar)}}" print>{{ $land->upload_pattedar}}</a></div>
                                                            </div>
                                                            <hr />
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="jumbotron">
                                            <h5>Bank Details</h5>
                                            <a href="#" class="btn btn-md btn-info" role="button" data-bs-toggle="modal" data-bs-target="#viewBank{{($farmers->id)}}">See all</a>
                                            <div class="modal fade" id="viewBank{{($farmers->id)}}" tabindex="-1" aria-labelledby="viewBankLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewBankLabel">Bank Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Bank Name</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->bank_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>IFSC Code</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->ifsc_code}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Branch Name</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->branch_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Account No.</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->account_no}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Account Name</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->account_name}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Bank Branch</b></div>
                                                                <div class="col-md-6"><p>{{ $farmers->bank_branch_address}}</p></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Upload Cancel Check</b></div>
                                                                <div class="col-md-6"><a href="{{url('/storage/bank-images/'. $farmers->upload_cancel_check)}}" print>{{ $farmers->upload_cancel_check}}</a></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Upload Passbook</b></div>
                                                                <div class="col-md-6"><a href="{{url('/storage/bank-images/'. $farmers->upload_passbook)}}" print>{{ $farmers->upload_passbook}}</a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="jumbotron">
                                            <h5>Detail Project Report</h5>
                                            @if(!empty($farmers->project_note))
                                            <a href="{{url('/storage/scheme-documents/'.date('Y').'/'.$farmers->project_note)}}" class="btn btn-md btn-info" role="button">View</a>
                                            @else
                                            <p>No Record</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="jumbotron">
                                            <h5>Self Declaration</h5>
                                            @if(!empty($farmers->self_declaration))
                                            <a href="{{url('/storage/scheme-documents/'.date('Y').'/'.$farmers->self_declaration)}}" class="btn btn-md btn-info" role="button">View</a>
                                            @else
                                            <p>No Record</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="jumbotron">
                                            <h5>All Documents</h5>
                                            <a href="#" class="btn btn-md btn-info" role="button" data-bs-toggle="modal" data-bs-target="#viewDoc{{($farmers->id)}}">See all</a>
                                            <div class="modal fade" id="viewDoc{{($farmers->id)}}" tabindex="-1" aria-labelledby="viewDocLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewDocLabel">Documents</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Basic Technical Data Sheet of Solar Plant</b></div>
                                                                @if(!empty($farmers->technical_datasheet))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'.$farmers->technical_datasheet)}}" print>{{ $farmers->technical_datasheet}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Bank Sanction Letter with Process Note</b></div>
                                                                @if(!empty($farmers->bank_sanction))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'. $farmers->bank_sanction)}}" print>{{ $farmers->bank_sanction}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Quotation of Solar PV Plant</b></div>
                                                                @if(!empty($farmers->quotation_solar))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'. $farmers->quotation_solar)}}" print>{{ $farmers->quotation_solar}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Site Plan</b></div>
                                                                @if(!empty($farmers->site_plan))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'. $farmers->site_plan)}}" print>{{ $farmers->site_plan}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Partnership Deed Copy</b></div>
                                                                @if(!empty($farmers->partnership_deep))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'. $farmers->partnership_deep)}}" print>{{ $farmers->partnership_deep}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Pan Card and Aadhaar Card</b></div>
                                                                @if(!empty($farmers->pan_aadhar))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'. $farmers->pan_aadhar)}}" print>{{ $farmers->pan_aadhar}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Location Plan</b></div>
                                                                @if(!empty($farmers->location_plan))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'. $farmers->location_plan)}}" print>{{ $farmers->location_plan}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Land Documents</b></div>
                                                                @if(!empty($farmers->land_documents))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'. $farmers->land_documents)}}" print>{{ $farmers->land_documents}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6"><b>Other Documents(Optional)</b></div>
                                                                @if(!empty($farmers->other_documents))
                                                                <div class="col-md-6"><p><a href="{{url('/storage/scheme-documents/'.date('Y').'/'. $farmers->other_documents)}}" print>{{ $farmers->other_documents}}</a></p></div>
                                                                @else
                                                                <div class="col-md-6"><p>No Record</p></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <form>
                                <input type="hidden" name="farmer_id" value="{{$farmers->farmer_id}}"/>
                            </form>
                        </div>
                        
                    </div>
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
