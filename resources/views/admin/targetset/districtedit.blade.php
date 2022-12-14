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
.w-6{
    width: 6%;
}
.w-15{
    width: 15%;
}
.w-18{
    width: 17%;
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
                            
                            <form class="row g-3" method="POST"  enctype="multipart/form-data"  action="{{route('manage-subsidy-district')}}">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        @php
                                        $minYear = date("Y", time()) - 1;
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
                                        <select class="form-select" @if(auth()->user()->role_id!=3) readonly="readonly" @endif required name="district_id" id="district_id" aria-label="Select District">
                                            <option value="">Select District</option>
                                            @forelse($districts as $district)
                                            <option @if(!empty($sdistrict)) @if($sdistrict == $district->id) selected @endif @endif value="{{$district->id}}">{{$district->district_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="sub_component_name">District</label>
                                    </div>
                                </div>
                                <div class="col-md-12"><p class="text-danger">Note: Please save entry after assign target. If assigned target is invalid then it will be refresh the page.</p></div>
                                @if(!empty($year) && !empty($sdistrict))
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="w-15" rowspan="2">Component/ Sub Component/ Crop/Item</th>
                                                <th class="w-8" rowspan="2">Unit</th>
                                                <th class="w-10" rowspan="2">Cost Norms (Rs.)</th>
                                                <th class="w-10" rowspan="2">Unassigned Targets/ Total Targets</th>
                                                <th class="w-20" colspan="4">Physical Target</th>
                                                <th class="w-20" colspan="4">Financial Target(Rs.)</th>
                                                <th class="w-15" rowspan="2">Remarks</th>
                                            </tr>
                                            <tr>
                                                <th class="w-8">Gen.</th>
                                                <th class="w-8">SC</th>
                                                <th class="w-8">ST</th>
                                                <th class="w-8">Women</th>
                                                <th class="w-8">Gen.</th>
                                                <th class="w-8">SC</th>
                                                <th class="w-8">ST</th>
                                                <th class="w-8">Women</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="13">
                                                    <table class="table-bordered" style="width:100%">
                                                        @inject('component', 'App\Models\Component')
                                                        @inject('type', 'App\Models\SchemeSubCategory')
                                                        @forelse($scheme_subcategory as  $parent_category) 
                                                        <?php 
                                                        ?>
                                                           @if(!empty($parent_category['cat'])) 
                                                                @forelse($parent_category['cat'] as $scheme_category)
                                                                
                                                                    @if(!empty($scheme_category['sub_cat']) )
                                                                        <!-- component type -->

                                                                        @forelse($scheme_category['sub_cat'] as $key => $component_type) 
                                                                        <tr>
                                                                            <th class="card-title">{{$component_type['subscheme_name']}}</th>                                                                
                                                                        </tr>
                                                                        

                                                                        <!-- component -->
                                                                        @php //print_r($component); @endphp
                                                                        @if(!empty($component_type['scheme']))   
                                                                        <tr>
                                                                            <td>
                                                                                <table class="table-bordered" style="width:100%">
                                                                                    <!-- scheme -->
                                                                                    @forelse($component_type['scheme'] as $key => $scheme)
                                                                                    <tr>
                                                                                        <td class="w-15 text-primary">
                                                                                        {{ $scheme['scheme_name'] }}
                                                                                        </td>
                                                                                        <td colspan="12"></td>
                                                                                    </tr>
                                                                                    <!-- targets -->
                                                                                    @php
                                                                                        $targetsset= $type->fetchtargetstate($scheme['scheme_subcategory_id'], $scheme['component_id'], $scheme['sub_component_id'], $scheme['scheme_id']); 
                                                                                        $targetdistrict = $type->fetchtargetdistrict($sdistrict,$targetsset->id, $year);                                
                                                                                    @endphp
                                                                                    <!-- if both sector present -->
                                                                                    @if(!empty($scheme['public_range']) && !empty($scheme['private_range']))
                                                                                    <tr>
                                                                                        <td class="w-15">
                                                                                        Public Sector
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>                                                                                     
                                                                                        <td class="w-8">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                            @endphp
                                                                                            {{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format((isset($alltargetdistrict->public)?$alltargetdistrict->public:0), 2)) : 0.00) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                 
                                                                                        </td>
                                                                                        <td class="w-8">                                                                                            
                                                                                            <input type="hidden" name="target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_gen_target[]" value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="gen_target[]" @if(empty($targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}" onChange="return getgenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_sc_target[]" value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="sc_target[]" @if(empty($targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}" onChange="return getscvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_st_target[]" value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="st_target[]" @if(empty($targetdistrict->st_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->st_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}" onChange="return getstvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_women_target[]" value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="women_target[]" @if(empty($targetdistrict->women_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->women_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}" onChange="return getwomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" name="district_remarks[]" value="{{ empty($targetdistrict->district_remarks)?'': $targetdistrict->district_remarks }}" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="w-18">
                                                                                            Private Sector
                                                                                        </td>
                                                                                        <td class="w-6">
                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>
                                                                                        <td class="w-6">
                                                                                        @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                        @endphp
                                                                                        {{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format((isset($alltargetdistrict->private)?$alltargetdistrict->private:0), 2)) : 0.00) }}  / {{ number_format($targetsset->private_physical_target, 2) }}                                                                                                
                                                                                        </td>
                                                                                        
                                                                                        <td class="w-6">
                                                                                            <input type="hidden" name="private_target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_private_gen_target[]" value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" id="private_gen_target[]" name="private_gen_target[]" @if(empty($targetdistrict->private_gen_target) && !empty($targetset->private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}" onChange="return getprivategenvalues(this);"/>
                                                                                        </td>
                                                                                        
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_private_sc_target[]" value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="private_sc_target[]" @if(empty($targetdistrict->private_sc_target) && !empty($targetset->private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}" onChange="return getprivatescvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_private_st_target[]" value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="private_st_target[]" @if(empty($targetdistrict->private_st_target) && !empty($targetset->private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}" onChange="return getprivatestvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_private_women_target[]" value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="private_women_target[]" @if(empty($targetdistrict->private_women_target) && !empty($targetset->private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}" onChange="return getprivatewomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-15">
                                                                                            <input type="text" class="w-80" name="district_private_remarks[]" value="{{ empty($targetdistrict->district_private_remarks)?'': $targetdistrict->district_private_remarks }}"/>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @else
                                                                                        <!-- else part -->
                                                                                        <!-- if only public sector present -->
                                                                                        @if(!empty($scheme['public_range']))
                                                                                        <tr>
                                                                                        <td class="w-15">
                                                                                        Public Sector
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>                                                                                     
                                                                                        <td class="w-8">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                            @endphp
                                                                                            {{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format((isset($alltargetdistrict->public)?$alltargetdistrict->public:0), 2)) : 0.00) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                 
                                                                                        </td>
                                                                                        <td class="w-8">                                                                                            
                                                                                            <input type="hidden" name="target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_gen_target[]" value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="gen_target[]" @if(empty($targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}" onChange="return getgenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_sc_target[]" value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="sc_target[]" @if(empty($targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}" onChange="return getscvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_st_target[]" value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="st_target[]" @if(empty($targetdistrict->st_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->st_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}" onChange="return getstvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_women_target[]" value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="women_target[]" @if(empty($targetdistrict->women_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->women_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}" onChange="return getwomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" name="district_remarks[]" value="{{ empty($targetdistrict->district_remarks)?'': $targetdistrict->district_remarks }}" />
                                                                                        </td>
                                                                                    </tr>
                                                                                        @endif
                                                                                        <!-- if only private sector present -->
                                                                                        @if(!empty($scheme['private_range']))
                                                                                        <tr>
                                                                                            <td class="w-18">
                                                                                                Private Sector
                                                                                            </td>
                                                                                            <td class="w-6">
                                                                                                <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                            </td>
                                                                                            <td class="w-10">
                                                                                                <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                            </td>
                                                                                            <td class="w-6">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                        @endphp
                                                                                        {{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : 0.00) }}  / {{ number_format($targetsset->private_physical_target, 2) }}
                                                                                            </td>
                                                                                            
                                                                                            <td class="w-6">
                                                                                                <input type="hidden" name="private_target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="hidden" name="old_private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                <input type="hidden" name="private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                <input type="hidden" name="old_private_gen_target[]" value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" id="private_gen_target[]" name="private_gen_target[]" @if(empty($targetdistrict->private_gen_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}" onChange="return getprivategenvalues(this);"/>
                                                                                            </td>
                                                                                            
                                                                                            <td class="w-8">
                                                                                            <input type="hidden" name="old_private_sc_target[]" value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="private_sc_target[]" @if(empty($targetdistrict->private_sc_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}" onChange="return getprivatescvalues(this);"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="hidden" name="old_private_st_target[]" value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="private_st_target[]" @if(empty($targetdistrict->private_st_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}" onChange="return getprivatestvalues(this);"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                            <input type="hidden" name="old_private_women_target[]" value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}"/>
                                                                                                <input type="text" maxlength="9" class="w-80" name="private_women_target[]" @if(empty($targetdistrict->private_women_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}" onChange="return getprivatewomenvalues(this);"/>
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_gen_target, 2) }}" readonly="readonly" />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_sc_target, 2) }}" readonly="readonly" />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_st_target, 2) }}" readonly="readonly" />
                                                                                            </td>
                                                                                            <td class="w-8">
                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_women_target, 2) }}" readonly="readonly" />
                                                                                            </td>
                                                                                            <td class="w-15">
                                                                                                <input type="text" class="w-80" name="district_private_remarks[]" value="{{ empty($targetdistrict->district_private_remarks)?'': $targetdistrict->district_private_remarks }}"/>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @endif
                                                                                        <!-- else end part -->
                                                                                    @endif
                                                                                    <!-- end target -->
                                                                                    @empty
                                                                                    @endforelse
                                                                                </table>
                                                                            </td>
                                                                        </tr>                                                                                        <!-- end scheme -->
                                                                        @endif
                                                                        
                                                                        @if(!empty($component_type['comp']))
                                                                        
                                                                        @forelse($component_type['comp'] as $key => $components)
                                                                        <tr>
                                                                            <td>   
                                                                                <table class="table-bordered" style="width:100%">
                                                                                    <tr>
                                                                                        <th>{{ $components['component_name']}}</th>
                                                                                    </tr>
                                                                                    @if(!empty($components['scheme']))
                                                                                    
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table class="table-bordered" style="width:100%">
                                                                                                <!-- scheme -->
                                                                                                @forelse($components['scheme'] as $key => $scheme)
                                                                                                <tr>
                                                                                                    <td class="w-18 text-primary">
                                                                                                    {{ $scheme['scheme_name'] }}
                                                                                                    </td>
                                                                                                    <td colspan="12"></td>
                                                                                                </tr>
                                                                                                <!-- targets -->
                                                                                                @php
                                                                                                    $targetsset= $type->fetchtargetstate($scheme['scheme_subcategory_id'], $scheme['component_id'], $scheme['sub_component_id'], $scheme['scheme_id']); 
                                                                                                    $targetdistrict = $type->fetchtargetdistrict($sdistrict,$targetsset->id, $year);
                                                                                                    
                                                                                                  @endphp
                                                                                                <!-- if both sector present -->
                                                                                                @if(!empty($scheme['public_range']) && !empty($scheme['private_range']))
                                                                                                <tr>
                                                                                        <td class="w-15">
                                                                                        Public Sector
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>                                                                                     
                                                                                        <td class="w-8">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                            @endphp
                                                                                            {{ $targetsset->physical_target }}
                                                                                                 {{(!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format((isset($alltargetdistrict->public)?$alltargetdistrict->public:0), 2)) : 0.00) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                 
                                                                                        </td>
                                                                                        <td class="w-8">                                                                                            
                                                                                            <input type="hidden" name="target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_gen_target[]" value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="gen_target[]" @if(empty($targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}" onChange="return getgenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_sc_target[]" value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="sc_target[]" @if(empty($targetdistrict->sc_target) && !empty($targetdistrict->assigned_physical_target)) readonly="readonly" @endif @if(empty($targetdistrict->sc_target) && empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}" onChange="return getscvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_st_target[]" value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="st_target[]" @if(empty($targetdistrict->st_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->st_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}" onChange="return getstvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_women_target[]" value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="women_target[]" @if(empty($targetdistrict->women_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->women_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}" onChange="return getwomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" name="district_remarks[]" value="{{ empty($targetdistrict->district_remarks)?'': $targetdistrict->district_remarks }}" />
                                                                                        </td>
                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td class="w-18">
                                                                                                            Private Sector
                                                                                                        </td>
                                                                                                        <td class="w-6">
                                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                                        </td>
                                                                                                        <td class="w-10">
                                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                                        </td>
                                                                                                        <td class="w-6">
                                                                                                        @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                                        @endphp
                                                                                                        {{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : 0.00) }}  / {{ number_format($targetsset->private_physical_target, 2) }}
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-6">
                                                                                                            <input type="hidden" name="private_target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                                            <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                            <input type="hidden" name="old_private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                            <input type="hidden" name="private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                            <input type="hidden" name="old_private_gen_target[]" value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" id="private_gen_target[]" name="private_gen_target[]" @if(empty($targetdistrict->private_gen_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}" onChange="return getprivategenvalues(this);"/>
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_sc_target[]" value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_sc_target[]" @if(empty($targetdistrict->private_sc_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}" onChange="return getprivatescvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_st_target[]" value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_st_target[]" @if(empty($targetdistrict->private_st_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}" onChange="return getprivatestvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_women_target[]" value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_women_target[]" @if(empty($targetdistrict->private_women_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}" onChange="return getprivatewomenvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_gen_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_sc_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_st_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_women_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-15">
                                                                                                            <input type="text" class="w-80" name="district_private_remarks[]" value="{{ empty($targetdistrict->district_private_remarks)?'': $targetdistrict->district_private_remarks }}"/>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @else
                                                                                                    <!-- else part -->
                                                                                                    <!-- if only public sector present -->
                                                                                                    @if(!empty($scheme['public_range']))
                                                                                                    <tr>
                                                                                        <td class="w-15">
                                                                                        Public Sector
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>                                                                                     
                                                                                        <td class="w-8">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                            @endphp
                                                                                            {{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format((isset($alltargetdistrict->public)?$alltargetdistrict->public:0), 2)) : 0.00) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                 
                                                                                        </td>
                                                                                        <td class="w-8">                                                                                            
                                                                                            <input type="hidden" name="target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_gen_target[]" value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="gen_target[]" @if(empty($targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}" onChange="return getgenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_sc_target[]" value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="sc_target[]" @if(empty($targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}" onChange="return getscvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_st_target[]" value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="st_target[]" @if(empty($targetdistrict->st_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->st_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}" onChange="return getstvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_women_target[]" value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="women_target[]" @if(empty($targetdistrict->women_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->women_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}" onChange="return getwomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" name="district_remarks[]" value="{{ empty($targetdistrict->district_remarks)?'': $targetdistrict->district_remarks }}" />
                                                                                        </td>
                                                                                    </tr>
                                                                                                    @endif
                                                                                                    <!-- if only private sector present -->
                                                                                                    @if(!empty($scheme['private_range']))
                                                                                                    <tr>
                                                                                                        <td class="w-18">
                                                                                                            Private Sector
                                                                                                        </td>
                                                                                                        <td class="w-6">
                                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                                        </td>
                                                                                                        <td class="w-10">
                                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                                        </td>
                                                                                                        <td class="w-6">
                                                                                                        @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                                        @endphp
                                                                                                        {{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : 0.00) }}  / {{ number_format($targetsset->private_physical_target, 2) }}                                                                     
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-6">
                                                                                                            <input type="hidden" name="private_target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                                            <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                            <input type="hidden" name="old_private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                            <input type="hidden" name="private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                            <input type="hidden" name="old_private_gen_target[]" value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" id="private_gen_target[]" name="private_gen_target[]" @if(empty($targetdistrict->private_gen_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}" onChange="return getprivategenvalues(this);"/>
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_sc_target[]" value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_sc_target[]" @if(empty($targetdistrict->private_sc_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}" onChange="return getprivatescvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_st_target[]" value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_st_target[]" @if(empty($targetdistrict->private_st_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}" onChange="return getprivatestvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_women_target[]" value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_women_target[]" @if(empty($targetdistrict->private_women_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}" onChange="return getprivatewomenvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_gen_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_sc_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_st_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_women_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-15">
                                                                                                            <input type="text" class="w-80" name="district_private_remarks[]" value="{{ empty($targetdistrict->district_private_remarks)?'': $targetdistrict->district_private_remarks }}"/>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @endif
                                                                                                    <!-- else end part -->
                                                                                                @endif
                                                                                                <!-- end target -->
                                                                                                @empty
                                                                                                @endforelse
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>                                                                                        <!-- end scheme -->
                                                                                    @endif
                                                                                    
                                                                                    @if(!empty($components['subcomp']))
                                                                                    
                                                                                    <!-- sub component -->
                                                                                        @forelse($components['subcomp'] as $key => $subcomponent)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table class="table-bordered" style="width:100%">
                                                                                                    <tr>
                                                                                                        <th colspan="13" class="card-title bg-legend">
                                                                                                        {{ $subcomponent['sub_component_name']}}
                                                                                                        </th>
                                                                                                    </tr>
                                                                                                    @if(!empty($subcomponent['scheme']))
                                                                                    
                                                                                                    <!-- scheme -->
                                                                                                    @forelse($subcomponent['scheme'] as $key => $scheme)
                                                                                                    <tr>
                                                                                                        <td class="w-15 text-primary">
                                                                                                        {{ $scheme['scheme_name'] }}
                                                                                                        </td>
                                                                                                        <td colspan="12"></td>
                                                                                                    </tr>
                                                                                                    <!-- targets -->
                                                                                                    @php 
                                                                                                        $targetsset= $type->fetchtargetstate($scheme['scheme_subcategory_id'], $scheme['component_id'], $scheme['sub_component_id'], $scheme['scheme_id']); 
                                                                                                        $targetdistrict = $type->fetchtargetdistrict($sdistrict,$targetsset->id, $year);
                                                                                                        
                                                                                                    @endphp
                                                                                                    <!-- if both sector present -->
                                                                                                    @if(!empty($scheme['public_range']) && !empty($scheme['private_range']))
                                                                                                    <tr>
                                                                                        <td class="w-15">
                                                                                        Public Sector
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>                                                                                     
                                                                                        <td class="w-8">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                            @endphp
                                                                                            {{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format((isset($alltargetdistrict->public)?$alltargetdistrict->public:0), 2)) : 0.00) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                 
                                                                                        </td>
                                                                                        <td class="w-8">                                                                                            
                                                                                            <input type="hidden" name="target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_gen_target[]" value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="gen_target[]" @if(empty($targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}" onChange="return getgenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_sc_target[]" value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="sc_target[]" @if(empty($targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}" onChange="return getscvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_st_target[]" value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="st_target[]" @if(empty($targetdistrict->st_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->st_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}" onChange="return getstvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_women_target[]" value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="women_target[]" @if(empty($targetdistrict->women_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->women_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}" onChange="return getwomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" name="district_remarks[]" value="{{ empty($targetdistrict->district_remarks)?'': $targetdistrict->district_remarks }}" />
                                                                                        </td>
                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td class="w-18">
                                                                                                            Private Sector
                                                                                                        </td>
                                                                                                        <td class="w-6">
                                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                                        </td>
                                                                                                        <td class="w-10">
                                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                                        </td>
                                                                                                        <td class="w-6">
                                                                                                        @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                                        @endphp
                                                                                                        {{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : 0.00) }}  / {{ number_format($targetsset->private_physical_target, 2) }}
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-6">
                                                                                                            <input type="hidden" name="private_target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                                            <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                            <input type="hidden" name="old_private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                            <input type="hidden" name="private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                            <input type="hidden" name="old_private_gen_target[]" value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" id="private_gen_target[]" name="private_gen_target[]" @if(empty($targetdistrict->private_gen_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}" onChange="return getprivategenvalues(this);"/>
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_sc_target[]" value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_sc_target[]" @if(empty($targetdistrict->private_sc_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}" onChange="return getprivatescvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_st_target[]" value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_st_target[]" @if(empty($targetdistrict->private_st_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}" onChange="return getprivatestvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_women_target[]" value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_women_target[]" @if(empty($targetdistrict->private_women_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}" onChange="return getprivatewomenvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_gen_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_sc_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_st_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_women_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-15">
                                                                                                            <input type="text" class="w-80" name="district_private_remarks[]" value="{{ empty($targetdistrict->district_private_remarks)?'': $targetdistrict->district_private_remarks }}"/>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @else
                                                                                                     <!-- else part -->
                                                                                                     <!-- if only public sector present -->
                                                                                                     @if(!empty($scheme['public_range']))
                                                                                                     <tr>
                                                                                        <td class="w-15">
                                                                                        Public Sector
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>                                                                                     
                                                                                        <td class="w-8">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                            @endphp
                                                                                            {{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format((isset($alltargetdistrict->public)?$alltargetdistrict->public:0), 2)) : 0.00) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                 
                                                                                        </td>
                                                                                        <td class="w-8">                                                                                            
                                                                                            <input type="hidden" name="target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_gen_target[]" value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="gen_target[]" @if(empty($targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}" onChange="return getgenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_sc_target[]" value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="sc_target[]" @if(empty($targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}" onChange="return getscvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_st_target[]" value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="st_target[]" @if(empty($targetdistrict->st_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->st_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}" onChange="return getstvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_women_target[]" value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="women_target[]" @if(empty($targetdistrict->women_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->women_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}" onChange="return getwomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" name="district_remarks[]" value="{{ empty($targetdistrict->district_remarks)?'': $targetdistrict->district_remarks }}" />
                                                                                        </td>
                                                                                    </tr>
                                                                                                        @endif
                                                                                                        <!-- if only private sector present -->
                                                                                                        @if(!empty($scheme['private_range']))
                                                                                                        <tr>
                                                                                                            <td class="w-18">
                                                                                                                Private Sector
                                                                                                            </td>
                                                                                                            <td class="w-6">
                                                                                                                <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                                            </td>
                                                                                                            <td class="w-10">
                                                                                                                <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                                            </td>
                                                                                                            <td class="w-6">
                                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                                            @endphp
                                                                                                            {{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : 0.00) }}  / {{ number_format($targetsset->private_physical_target, 2) }}
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-6">
                                                                                                                <input type="hidden" name="private_target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                <input type="hidden" name="old_private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                                <input type="hidden" name="private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                                <input type="hidden" name="old_private_gen_target[]" value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}"/>
                                                                                                                <input type="text" maxlength="9" class="w-80" id="private_gen_target[]" name="private_gen_target[]" @if(empty($targetdistrict->private_gen_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}" onChange="return getprivategenvalues(this);"/>
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-8">
                                                                                                            <input type="hidden" name="old_private_sc_target[]" value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}"/>
                                                                                                                <input type="text" maxlength="9" class="w-80" name="private_sc_target[]" @if(empty($targetdistrict->private_sc_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}" onChange="return getprivatescvalues(this);"/>
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                            <input type="hidden" name="old_private_st_target[]" value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}"/>
                                                                                                                <input type="text" maxlength="9" class="w-80" name="private_st_target[]" @if(empty($targetdistrict->private_st_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}" onChange="return getprivatestvalues(this);"/>
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                            <input type="hidden" name="old_private_women_target[]" value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}"/>
                                                                                                                <input type="text" maxlength="9" class="w-80" name="private_women_target[]" @if(empty($targetdistrict->private_women_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}" onChange="return getprivatewomenvalues(this);"/>
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_gen_target, 2) }}" readonly="readonly" />
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_sc_target, 2) }}" readonly="readonly" />
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_st_target, 2) }}" readonly="readonly" />
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_women_target, 2) }}" readonly="readonly" />
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                                <input type="text" class="w-80" name="district_private_remarks[]" value="{{ empty($targetdistrict->district_private_remarks)?'': $targetdistrict->district_private_remarks }}"/>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        @endif
                                                                                                     <!-- else end part -->
                                                                                                    @endif
                                                                                                    <!-- end target -->
                                                                                                    @empty
                                                                                                    @endforelse
                                                                                                    <!-- end scheme -->
                                                                                                    @endif
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @empty
                                                                                        <!-- else sub component -->
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table class="table-bordered" style="width:100%">
                                                                                                    <tr>
                                                                                                    @if(!empty($subcomponent['scheme']))
                                                                                    
                                                                                                    <!-- scheme -->
                                                                                                    @forelse($subcomponent['scheme'] as $key => $scheme)
                                                                                                    <tr>
                                                                                                        <td class="w-15 text-primary">
                                                                                                        {{ $scheme['scheme_name'] }}
                                                                                                        </td>
                                                                                                        <td colspan="12"></td>
                                                                                                    </tr>
                                                                                                    <!-- targets -->
                                                                                                    @php 
                                                                                                        $targetsset= $type->fetchtargetstate($scheme['scheme_subcategory_id'], $scheme['component_id'], $scheme['sub_component_id'], $scheme['scheme_id']); 
                                                                                                        $targetdistrict = $type->fetchtargetdistrict($sdistrict,$targetsset->id, $year);
                                                                                                        
                                                                                                    @endphp
                                                                                                    <!-- if both sector present -->
                                                                                                    @if(!empty($scheme['public_range']) && !empty($scheme['private_range']))
                                                                                                    <tr>
                                                                                        <td class="w-15">
                                                                                        Public Sector
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>                                                                                     
                                                                                        <td class="w-8">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                            @endphp
                                                                                            {{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format((isset($alltargetdistrict->public)?$alltargetdistrict->public:0), 2)) : 0.00) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                 
                                                                                        </td>
                                                                                        <td class="w-8">                                                                                            
                                                                                            <input type="hidden" name="target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_gen_target[]" value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="gen_target[]" @if(empty($targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}" onChange="return getgenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_sc_target[]" value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="sc_target[]" @if(empty($targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}" onChange="return getscvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_st_target[]" value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="st_target[]" @if(empty($targetdistrict->st_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->st_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}" onChange="return getstvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_women_target[]" value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="women_target[]" @if(empty($targetdistrict->women_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->women_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}" onChange="return getwomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" name="district_remarks[]" value="{{ empty($targetdistrict->district_remarks)?'': $targetdistrict->district_remarks }}" />
                                                                                        </td>
                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td class="w-18">
                                                                                                            Private Sector
                                                                                                        </td>
                                                                                                        <td class="w-6">
                                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                                        </td>
                                                                                                        <td class="w-10">
                                                                                                            <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                                        </td>
                                                                                                        <td class="w-6">
                                                                                                        @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                                        @endphp
                                                                                                        {{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : 0.00) }}  / {{ number_format($targetsset->private_physical_target, 2) }}
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-6">
                                                                                                            <input type="hidden" name="private_target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                                            <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                            <input type="hidden" name="old_private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                            <input type="hidden" name="private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                            <input type="hidden" name="old_private_gen_target[]" value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" id="private_gen_target[]" name="private_gen_target[]" @if(empty($targetdistrict->private_gen_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}" onChange="return getprivategenvalues(this);"/>
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_sc_target[]" value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_sc_target[]" @if(empty($targetdistrict->private_sc_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}" onChange="return getprivatescvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_st_target[]" value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_st_target[]" @if(empty($targetdistrict->private_st_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}" onChange="return getprivatestvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                        <input type="hidden" name="old_private_women_target[]" value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}"/>
                                                                                                            <input type="text" maxlength="9" class="w-80" name="private_women_target[]" @if(empty($targetdistrict->private_women_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}" onChange="return getprivatewomenvalues(this);"/>
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_gen_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_sc_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_st_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-8">
                                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->private_women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_women_target, 2) }}" readonly="readonly" />
                                                                                                        </td>
                                                                                                        <td class="w-15">
                                                                                                            <input type="text" class="w-80" name="district_private_remarks[]" value="{{ empty($targetdistrict->district_private_remarks)?'': $targetdistrict->district_private_remarks }}"/>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    @else
                                                                                                     <!-- else part -->
                                                                                                     <!-- if only public sector present -->
                                                                                                     @if(!empty($scheme['public_range']))
                                                                                                     <tr>
                                                                                        <td class="w-15">
                                                                                        Public Sector
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                        <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                        </td>                                                                                     
                                                                                        <td class="w-8">
                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                            @endphp
                                                                                            {{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format((isset($alltargetdistrict->public)?$alltargetdistrict->public:0), 2)) : 0.00) }}  / {{ number_format($targetsset->physical_target, 2) }}                                                                                                 
                                                                                        </td>
                                                                                        <td class="w-8">                                                                                            
                                                                                            <input type="hidden" name="target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                            <input type="hidden" name="old_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="un_assigned[]" value="{{ (!empty($targetdistrict->assigned_physical_target) ? (number_format($targetsset->physical_target, 2)-number_format(isset($alltargetdistrict->public)?$alltargetdistrict->public:0, 2)) : number_format($targetsset->physical_target, 2)) }}"/>
                                                                                            <input type="hidden" name="old_gen_target[]" value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="gen_target[]" @if(empty($targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->gen_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->gen_target)?'0.00': $targetdistrict->gen_target }}" onChange="return getgenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_sc_target[]" value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="sc_target[]" @if(empty($targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->sc_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->sc_target)?'0.00': $targetdistrict->sc_target }}" onChange="return getscvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_st_target[]" value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="st_target[]" @if(empty($targetdistrict->st_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->st_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->st_target)?'0.00': $targetdistrict->st_target }}" onChange="return getstvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="hidden" name="old_women_target[]" value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}"/>
                                                                                            <input type="text" maxlength="9" class="w-80" name="women_target[]" @if(empty($targetdistrict->women_target)  && !empty($targetsset->physical_target)) readonly="readonly" @else @if(empty((float)$targetdistrict->women_target) && !empty($targetsset->physical_target)) readonly="readonly" @endif @endif value="{{ empty($targetdistrict->women_target)?'0.00': $targetdistrict->women_target }}" onChange="return getwomenvalues(this);"/>
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                            <input type="text" class="w-80" value="{{ empty($targetdistrict->gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->gen_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->sc_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->st_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-8">
                                                                                        <input type="text" class="w-80" value="{{ empty($targetdistrict->women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->women_target, 2) }}" readonly="readonly" />
                                                                                        </td>
                                                                                        <td class="w-10">
                                                                                            <input type="text" class="w-80" name="district_remarks[]" value="{{ empty($targetdistrict->district_remarks)?'': $targetdistrict->district_remarks }}" />
                                                                                        </td>
                                                                                    </tr>
                                                                                                        @endif
                                                                                                        <!-- if only private sector present -->
                                                                                                        @if(!empty($scheme['private_range']))
                                                                                                        <tr>
                                                                                                            <td class="w-18">
                                                                                                                Private Sector
                                                                                                            </td>
                                                                                                            <td class="w-6">
                                                                                                                <input type="text" class="w-80" readonly="readonly" value="{{ $scheme['units'] }}" />
                                                                                                            </td>
                                                                                                            <td class="w-10">
                                                                                                                <input type="text" class="w-80" readonly="readonly" value="{{$scheme['cost_norms']}}"/>
                                                                                                            </td>
                                                                                                            <td class="w-6">
                                                                                                            @php $alltargetdistrict = $type->fetchassignedtarget(isset($targetdistrict->target_state_id)?($targetdistrict->target_state_id):0);
                                                                                                            @endphp
                                                                                                            {{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : 0.00) }}  / {{ number_format($targetsset->private_physical_target, 2) }}
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-6">
                                                                                                                <input type="hidden" name="private_target_district_id[]" value="{{!empty($targetdistrict->id)?$targetdistrict->id:''}}"/>
                                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                <input type="hidden" name="old_private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                                <input type="hidden" name="private_un_assigned[]" value="{{ (!empty($targetdistrict->assigned_private_physical_target) ? (number_format($targetsset->private_physical_target, 2)-number_format(isset($alltargetdistrict->private)?$alltargetdistrict->private:0, 2)) : number_format($targetsset->private_physical_target, 2)) }}"/>
                                                                                                                <input type="hidden" name="old_private_gen_target[]" value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}"/>
                                                                                                                <input type="text" maxlength="9" class="w-80" id="private_gen_target[]" name="private_gen_target[]" @if(empty($targetdistrict->private_gen_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_gen_target)?'0.00': $targetdistrict->private_gen_target }}" onChange="return getprivategenvalues(this);"/>
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-8">
                                                                                                            <input type="hidden" name="old_private_sc_target[]" value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}"/>
                                                                                                                <input type="text" maxlength="9" class="w-80" name="private_sc_target[]" @if(empty($targetdistrict->private_sc_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_sc_target)?'0.00': $targetdistrict->private_sc_target }}" onChange="return getprivatescvalues(this);"/>
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                            <input type="hidden" name="old_private_st_target[]" value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}"/>
                                                                                                                <input type="text" maxlength="9" class="w-80" name="private_st_target[]" @if(empty($targetdistrict->private_st_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_st_target)?'0.00': $targetdistrict->private_st_target }}" onChange="return getprivatestvalues(this);"/>
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                            <input type="hidden" name="old_private_women_target[]" value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}"/>
                                                                                                                <input type="text" maxlength="9" class="w-80" name="private_women_target[]" @if(empty($targetdistrict->private_women_target) && !empty($targetdistrict->assigned_private_physical_target)) readonly="readonly" @endif value="{{ empty($targetdistrict->private_women_target)?'0.00': $targetdistrict->private_women_target }}" onChange="return getprivatewomenvalues(this);"/>
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_gen_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_gen_target, 2) }}" readonly="readonly" />
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_sc_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_sc_target, 2) }}" readonly="readonly" />
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_st_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_st_target, 2) }}" readonly="readonly" />
                                                                                                            </td>
                                                                                                            <td class="w-8">
                                                                                                                <input type="text" class="w-80" value="{{ empty($targetdistrict->private_women_target)? '0.00': number_format((float)$scheme['cost_norms']*(float)$targetdistrict->private_women_target, 2) }}" readonly="readonly" />
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                                <input type="text" class="w-80" name="district_private_remarks[]" value="{{ empty($targetdistrict->district_private_remarks)?'': $targetdistrict->district_private_remarks }}"/>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        @endif
                                                                                                     <!-- else end part -->
                                                                                                    @endif
                                                                                                    <!-- end target -->
                                                                                                    @empty
                                                                                                    @endforelse
                                                                                                    <!-- end scheme -->
                                                                                                    @endif
                                                                                                </table>
                                                                                            <td>
                                                                                        </tr>    
                                                                                        <!-- else end sub component -->
                                                                                        @endforelse
                                                                                    @endif
                                                                                    <!-- sub component end -->
                                                                                </table>
                                                                            </td>
                                                                        </tr>

                                                                        @empty
                                                                        
                                                                        @endforelse
                                                                                
                                                                        @endif
                                                                        <!-- component end -->

                                                                        @empty
                                                                        @endforelse

                                                                        <!-- component type end -->
                                                                    @endif
                                                                @empty
                                                                @endforelse
                                                           @endif
                                                           <!-- category end -->
                                                        @empty
                                                        @endforelse
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @php if(\Auth::user()->role_id == 3){ @endphp
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                                </div>
                                @php } @endphp
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
<script src="{{ asset('js/subsidy_targets.js')}}"></script>
<script>    
    $(document).ready(function () {
        $('#example').DataTable();
        $('#year').on('change', function(){
            var id = $(this).val();
            var district_id = $('#district_id').val();
            console.log(district_id, id)
            if(id != null && (district_id == '' || district_id == null || district_id == undefined)){
                swal("Please select district", {
                    icon: "error",
                });
            }else{
                var url = '{{url("/manage-subsidy-district")}}?year='+id+'&district_id='+district_id;
                window.location = url;
            }
                         
        });  
        
        $('#district_id').on('change', function(){
            var id = $(this).val();
            var year = $('#year').val();
            if(id != null && (year == '' || year == null || year == undefined)){
                swal("Please select financial year", {
                    icon: "error",
                });
            }else{
                var url = '{{url("/manage-subsidy-district")}}?year='+year+'&district_id='+id;
                window.location = url;
            }
                         
        }); 
        
    });

</script>
@endpush
