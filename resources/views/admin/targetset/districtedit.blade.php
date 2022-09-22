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
    .class-link{
  color:#6cc417;
  text-decoration:none;
}

.class-link:hover{
 color:#ffbb00; 
}
fieldset{
    border-width: 2px;
    border-style: groove;
    border-color: rgb(192, 192, 192);
    border-image: initial;
}
legend{
    float: unset;
    width: unset;
    padding: 10px !important;
}
.bg-legend{
    background: #4db73b2b !important;
    border-radius: 4px;
}
.w-20{
    width: 20%;
}
.w-10{
    width: 10%;
}
.w-8{
    width: 5%;
}
.w-15{
    width: 15%;
}
.w-40{
    width: 40%;
}
.w-50{
    width: 50%;
}
.w-80{
    width: 80%;
}
th.card-title{
    background: #ff8c0036;
    padding-left: 5px;
}
</style>
<div class="pagetitle">
    <h1>Manage Subsidy Targets for District</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/manage-subsidy-district')}}">Manage Subsidy Targets for District</a></li>
    </ol>
    <!-- <img src="{{asset('storage/app/public/image/180X180.png')}}" /> -->
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                        <h5 class="card-title">Manage Subsidy Targets for District</h5>
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
                            <!-- Floating Labels Form action="{{ ('update-subsidy-state') }}"-->
                            
                            <form class="row g-3" method="POST"  enctype="multipart/form-data"  action="{{route('manage-subsidy-state')}}">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        @php
                                        $minYear = date("Y", time()) - 10;
                                        $curYear = date("Y", time()) + 1;

                                        $yearRange = range($minYear, $curYear);
                                        $prevYear = date('Y',strtotime('-1 Year'));
                                        $currYear = date('y');
                                        $conselValue = $prevYear.'-'.$currYear;
                                        @endphp
                                        <select class="form-select" required name="year" id="year" aria-label="Select Financial Year">
                                            <option value="">Select Financial Year</option>
                                            @foreach($yearRange as $key => $value)
                                            @php 
                                            $pfYear = $value-1;
                                            $prefix = substr($pfYear,-0);
                                            $PreYear=substr($value,-2);
                                            $selValue =  $prefix.'-'. $PreYear;
                                            @endphp
                                            <option @if($year == $selValue) selected @endif value="{{ $selValue }}">{{ $selValue }}</option>
                                            @endforeach
                                        </select>
                                        <label for="sub_component_name">Financial Year</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">                                        
                                        <select class="form-select" required name="year" id="year" aria-label="Select District">
                                            <option value="">Select District</option>
                                            
                                        </select>
                                        <label for="sub_component_name">District</label>
                                    </div>
                                </div>
                                @if(!empty($year))
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="w-15" rowspan="2">Component/ Sub Component/ Crop/Item</th>
                                                <th class="w-8" rowspan="2">Unit</th>
                                                <th class="w-10" rowspan="2">Cost Norms (Rs.)</th>
                                                <th class="w-10" rowspan="2">Total Targets/ Unassigned Targets</th>
                                                <th class="w-20" colspan="4">Physical Target</th>
                                                <th class="w-20" colspan="4">Financial Target(Rs.)</th>
                                                <th class="w-15" rowspan="2">Remarks</th>
                                            </tr>
                                            <tr>
                                                <th class="w-8">Gen.</th>
                                                <th class="w-8">ST</th>
                                                <th class="w-8">SC</th>
                                                <th class="w-8">Women</th>
                                                <th class="w-8">Gen.</th>
                                                <th class="w-8">ST</th>
                                                <th class="w-8">SC</th>
                                                <th class="w-8">Women</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="13">
                                                    <table class="table-bordered" style="width:100%">
                                                        @inject('component', 'App\Models\Component')
                                                        @inject('type', 'App\Models\SchemeSubCategory')
                                                        @forelse($scheme_subcategory as $key => $cat)  
                                                            <tr>
                                                                @php $id=str_replace('category_id_','',$key);  @endphp
                                                                <th class="card-title">{{ $type->fetchSubSchemeCategory($id)->subcategory_name }}</th>                                                                
                                                            </tr>
                                                            <!-- start component -->
                                                            @forelse($cat as $comp) 
                                                            <tr>
                                                                <td>   
                                                                    <table class="table-bordered" style="width:100%">
                                                                        @if($comp->component_id && $comp->sub_component_id)
                                                                        <tr>
                                                                            <th>{{ $type->fetchComponentName($comp->component_id)->component_name}}</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="table-bordered" style="width:100%">
                                                                                    <tr>
                                                                                        <th colspan="13" class="card-title bg-legend">{{ $type->fetchSubComponentName($comp->sub_component_id)->sub_component_name}}</th>
                                                                                    </tr>
                                                                                    
                                                                                        <tr>
                                                                                            <td class="w-15 text-primary">
                                                                                            {{ $comp->scheme_name }}
                                                                                            </td>
                                                                                            <td colspan="12"></td>
                                                                                        </tr>
                                                                                        @php $targetsset= $comp->fetchtargetstate($comp->scheme_subcategory_id, $comp->component_id, $comp->sub_component_id, $comp->scheme_id); @endphp
                                                                                        @if(!empty($comp->public_range) && !empty($comp->private_range))
                                                                                        <tr>
                                                                                            <td class="w-15">
                                                                                            Public Sector
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                            <td class="w-10">
                                                                                            <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                            </td>                                                                                     
                                                                                            <td class="w-8">
                                                                                                {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-25">
                                                                                                <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'0.00': $targetsset->remarks }}" />
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                        <td class="w-15">
                                                                                            Private Sector
                                                                                            </td>
                                                                                            <td class="w-15">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                            </td>
                                                                                            <td class="w-10">
                                                                                                {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                            </td>
                                                                                            
                                                                                            <td class="w-8">
                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" value="{{number_format((float)$comp->cost_norms*(float)$targetsset->private_physical_target, 2)}}" disabled />
                                                                                            </td>
                                                                                            <td class="w-15">
                                                                                                <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'0.00': $targetsset->private_remarks }}"/>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @else
                                                                                            @if(!empty($comp->public_sector))
                                                                                            <tr>
                                                                                            <td class="w-15">
                                                                                                Public Sector
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                                </td>
                                                                                                <td class="w-10">
                                                                                                <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                                </td>
                                                                                                
                                                                                                <td class="w-8">
                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                    <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-15">
                                                                                                    <input type="text" class="w-80" name="remarks[]"/>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endif
                                                                                            @if(!empty($comp->private_sector))
                                                                                            <tr>
                                                                                            <td class="w-15">
                                                                                                Private Sector
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                                <td class="w-10">
                                                                                                <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                                </td>
                                                                                                
                                                                                                <td class="w-8">
                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                    <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-15">
                                                                                                    <input type="text" class="w-80" name="private_remarks[]"/>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                        @elseif ($comp->component_id && !$comp->sub_component_id)
                                                                        <tr>
                                                                            <th>{{ $type->fetchComponentName($comp->component_id)->component_name}}</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table class="table-bordered" style="width:100%">                                                                                  
                                                                                    
                                                                                        <tr>
                                                                                            <td class="w-15 text-primary">
                                                                                            {{ $comp->scheme_name }}hi
                                                                                            </td>
                                                                                            <td colspan="12"></td>
                                                                                        </tr>
                                                                                        @php $targetsset= $comp->fetchtargetstate($comp->scheme_subcategory_id, $comp->component_id, $comp->sub_component_id, $comp->scheme_id); @endphp
                                                                                        @if(!empty($comp->public_range) && !empty($comp->private_range))
                                                                                        <tr>
                                                                                        <td class="w-15">
                                                                                            Public Sector
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                            <td class="w-10">
                                                                                            <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                            </td>  
                                                                                            <td class="w-8">
                                                                                                {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                            </td>                                                                                   
                                                                                            
                                                                                            <td class="w-8">
                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-25">
                                                                                                <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'0.00': $targetsset->remarks }}" />
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                        <td class="w-15">
                                                                                            Private Sector
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                            <td class="w-10">
                                                                                            <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                            </td>
                                                                                            
                                                                                            <td class="w-8">
                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-25">
                                                                                                <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'0.00': $targetsset->private_remarks }}"/>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @else
                                                                                            @if(!empty($comp->public_sector))
                                                                                            <tr>
                                                                                            <td class="w-15">
                                                                                                Public Sector
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                                </td>
                                                                                                <td class="w-10">
                                                                                                <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                                </td>
                                                                                                
                                                                                                <td class="w-8">
                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                    <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-15">
                                                                                                    <input type="text" class="w-80" name="remarks[]"/>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endif
                                                                                            @if(!empty($comp->private_sector))
                                                                                            <tr>
                                                                                            <td class="w-15">
                                                                                                Private Sector
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                                <td class="w-10">
                                                                                                <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                                </td>
                                                                                                
                                                                                                <td class="w-8">
                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                    <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-15">
                                                                                                    <input type="text" class="w-80" name="private_remarks[]"/>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        @elseif (!$comp->component_id && !$comp->sub_component_id)
                                                                        <tr>
                                                                            <td>
                                                                                <table class="table-bordered" style="width:100%">                                                                                  
                                                                                    
                                                                                        <tr>
                                                                                            <td class="w-15 text-primary">
                                                                                            {{ $comp->scheme_name }}
                                                                                            </td>
                                                                                            <td colspan="12"></td>
                                                                                        </tr>
                                                                                        @php $targetsset= $comp->fetchtargetstate($comp->scheme_subcategory_id, $comp->component_id,$comp->sub_component_id, $comp->scheme_id); @endphp
                                                                                        @if(!empty($comp->public_range) && !empty($comp->private_range))
                                                                                        <tr>
                                                                                        <td class="w-15">
                                                                                            Public Sector
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                            <td class="w-10">
                                                                                            <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                            </td> 
                                                                                            <td class="w-8">
                                                                                                {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                            </td>                                                                                    
                                                                                            
                                                                                            <td class="w-8">
                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-25">
                                                                                                <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'0.00': $targetsset->remarks }}" />
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                        <td class="w-15">
                                                                                            Private Sector
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                            <td class="w-10">
                                                                                            <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                            </td>
                                                                                            
                                                                                            <td class="w-8">
                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                            </td>
                                                                                            <td class="w-15">
                                                                                                <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'0.00': $targetsset->private_remarks }}"/>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @else
                                                                                            @if(!empty($comp->public_sector))
                                                                                            <tr>
                                                                                            <td class="w-15">
                                                                                                Public Sector
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                                </td>
                                                                                                <td class="w-10">
                                                                                                <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                                </td>
                                                                                                
                                                                                                <td class="w-8">
                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                    <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-15">
                                                                                                    <input type="text" class="w-80" name="remarks[]"/>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endif
                                                                                            @if(!empty($comp->private_sector))
                                                                                            <tr>
                                                                                            <td class="w-15">
                                                                                                Private Sector
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                            <input type="text" class="w-80" disabled value="{{ $comp->units }}" />
                                                                                            </td>
                                                                                                <td class="w-10">
                                                                                                <input type="text" class="w-80" disabled value="{{$comp->cost_norms}}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    {{ number_format($targetsset->physical_target, 2) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                
                                                                                                </td>
                                                                                                
                                                                                                <td class="w-8">
                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                    <input type="text" maxlength="9" class="w-80" name="gen_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="sc_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="st_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                    <input type="text" maxlength="9" class="w-80" name="women_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ number_format((float)$comp->cost_norms*(float)$targetsset->physical_target, 2) }}" disabled />
                                                                                                </td>
                                                                                                <td class="w-15">
                                                                                                    <input type="text" class="w-80" name="private_remarks[]"/>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endif
                                                                                        @endif
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                             <!-- not start component -->
                                                            @endforelse                              
                                                            
                                                        @empty
                                                        @endforelse
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                                </div>
                            </form><!-- End floating Labels Form -->
                            @else
                            <p>Please select financial year</p>
                            @endif    
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
        $('#year').on('change', function(){
            var id = $(this).val();
            var url = '/manage-subsidy-district?year='+id;
            window.location = url;             
        });   
        
    });

</script>
@endpush
