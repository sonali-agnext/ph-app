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
    <h1>Manage Subsidy Targets for State</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/manage-subsidy-state')}}">Manage Subsidy Targets for State</a></li>
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
                        <h5 class="card-title">Manage Subsidy Targets for State</h5>
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
                                
                                @if(!empty($year))
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="w-20">Component/ Sub Component/ Crop/Item</th>
                                                <th class="w-10">Unit</th>
                                                <th class="w-15">Cost Norms (Rs.)</th>
                                                <th class="w-20">Physical Target</th>
                                                <th class="w-20">Financial Target(Rs.)</th>
                                                <th class="w-15">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="6">
                                                    <table class="table-bordered" style="width:100%">
                                                        @inject('component', 'App\Models\Component')
                                                        @inject('type', 'App\Models\SchemeSubCategory')

                                                        @forelse($scheme_subcategory as  $parent_category) 

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
                                                                                        <td colspan="5"></td>
                                                                                    </tr>
                                                                                    <!-- targets -->
                                                                                    @php
                                                                                        $targetsset= $type->fetchtargetstate($scheme['scheme_subcategory_id'], $scheme['component_id'], $scheme['sub_component_id'], $scheme['scheme_id']); 
                                                                                    @endphp
                                                                                    <!-- if both sector present -->
                                                                                    @if(!empty($scheme['public_range']) && !empty($scheme['private_range']))
                                                                                    <tr>
                                                                                                <td class="w-20">
                                                                                                Public Sector
                                                                                                </td>
                                                                                                <td class="w-10">
                                                                                                {{$scheme['units']}}
                                                                                                </td>
                                                                                                <td class="w-15">
                                                                                                {{$scheme['cost_norms']}}
                                                                                                </td>
                                                                                                
                                                                                                <td class="w-20">
                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                    <input type="text" maxlength="9" class="w-50" name="physical_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                </td>
                                                                                                <td class="w-20">
                                                                                                {{number_format((float)$scheme['cost_norms']*(float)$targetsset->physical_target, 2)}}
                                                                                                </td>
                                                                                                <td class="w-15">
                                                                                                    <input type="text" class="w-80" name="remarks[]"/>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                            <td class="w-20">
                                                                                            Private Sector
                                                                                            </td>
                                                                                            <td class="w-10">{{$scheme['units']}}</td>
                                                                                            <td class="w-15">
                                                                                            {{$scheme['cost_norms']}}
                                                                                            </td>
                                                                                            
                                                                                            <td class="w-20">
                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-50" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                            </td>
                                                                                            <td class="w-20">
                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->private_physical_target, 2)}}
                                                                                            </td>
                                                                                            <td class="w-15">
                                                                                                <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'0.00': $targetsset->private_remarks }}"/>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @else
                                                                                    @if(!empty($scheme['public_range']))
                                                                                        <tr>
                                                                                            <td class="w-20">
                                                                                            Public Sector
                                                                                            </td>
                                                                                            <td class="w-10">
                                                                                            {{$scheme['units']}}
                                                                                            </td>
                                                                                            <td class="w-15">
                                                                                            {{$scheme['cost_norms']}}
                                                                                            </td>
                                                                                            
                                                                                            <td class="w-20">
                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-50" name="physical_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                            </td>
                                                                                            <td class="w-20">
                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->physical_target, 2)}}
                                                                                            </td>
                                                                                            <td class="w-15">
                                                                                                <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'': $targetsset->remarks }}"/>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    @if(!empty($scheme['private_range']))
                                                                                        <tr>
                                                                                            <td class="w-20">
                                                                                            Private Sector
                                                                                            </td>
                                                                                            <td class="w-10">{{$scheme['units']}}</td>
                                                                                            <td class="w-15">
                                                                                            {{$scheme['cost_norms']}}
                                                                                            </td>
                                                                                            
                                                                                            <td class="w-20">
                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                <input type="text" maxlength="9" class="w-50" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                            </td>
                                                                                            <td class="w-20">
                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->private_physical_target, 2)}}
                                                                                            </td>
                                                                                            <td class="w-15">
                                                                                                <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'': $targetsset->private_remarks }}"/>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
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
                                                                                                    <td colspan="5"></td>
                                                                                                </tr>
                                                                                                <!-- targets -->
                                                                                                @php //print_r($scheme);
                                                                                                    $targetsset= $type->fetchtargetstate($scheme['scheme_subcategory_id'], $scheme['component_id'], $scheme['sub_component_id'], $scheme['scheme_id']); 
                                                                                                @endphp
                                                                                                <!-- if both sector present -->
                                                                                                @if(!empty($scheme['public_range']) && !empty($scheme['private_range']))
                                                                                                    <tr>
                                                                                                        <td class="w-20">
                                                                                                        Public Sector
                                                                                                        </td>
                                                                                                        <td class="w-10">
                                                                                                        {{$scheme['units']}}
                                                                                                        </td>
                                                                                                        <td class="w-15">
                                                                                                        {{$scheme['cost_norms']}}
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-20">
                                                                                                            <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                            <input type="text" maxlength="9" class="w-50" name="physical_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                        </td>
                                                                                                        <td class="w-20">
                                                                                                        {{number_format((float)$scheme['cost_norms']*(float)$targetsset->physical_target, 2)}}
                                                                                                        </td>
                                                                                                        <td class="w-15">
                                                                                                            <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'': $targetsset->remarks }}"/>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td class="w-20">
                                                                                                        Private Sector
                                                                                                        </td>
                                                                                                        <td class="w-10">{{$scheme['units']}}</td>
                                                                                                        <td class="w-15">
                                                                                                        {{$scheme['cost_norms']}}
                                                                                                        </td>
                                                                                                        
                                                                                                        <td class="w-20">
                                                                                                            <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                            <input type="text" maxlength="9" class="w-50" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                                        </td>
                                                                                                        <td class="w-20">
                                                                                                        {{number_format((float)$scheme['cost_norms']*(float)$targetsset->private_physical_target, 2)}}
                                                                                                        </td>
                                                                                                        <td class="w-15">
                                                                                                            <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'': $targetsset->private_remarks }}"/>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @else
                                                                                                    @if(!empty($scheme['public_range']))
                                                                                                        <tr>
                                                                                                            <td class="w-20">
                                                                                                            Public Sector
                                                                                                            </td>
                                                                                                            <td class="w-10">
                                                                                                            {{$scheme['units']}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                            {{$scheme['cost_norms']}}
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-20">
                                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                <input type="text" maxlength="9" class="w-50" name="physical_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                            </td>
                                                                                                            <td class="w-20">
                                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->physical_target, 2)}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                                <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'': $targetsset->remarks }}"/>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @endif
                                                                                                    @if(!empty($scheme['private_range']))
                                                                                                        <tr>
                                                                                                            <td class="w-20">
                                                                                                            Private Sector
                                                                                                            </td>
                                                                                                            <td class="w-10">{{$scheme['units']}}</td>
                                                                                                            <td class="w-15">
                                                                                                            {{$scheme['cost_norms']}}
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-20">
                                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                <input type="text" maxlength="9" class="w-50" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                                            </td>
                                                                                                            <td class="w-20">
                                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->private_physical_target, 2)}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                                <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'': $targetsset->private_remarks }}"/>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @endif
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
                                                                                                        <th colspan="6" class="card-title bg-legend">
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
                                                                                                        <td colspan="5"></td>
                                                                                                    </tr>
                                                                                                    <!-- targets -->
                                                                                                    @php //print_r($scheme);
                                                                                                        $targetsset= $type->fetchtargetstate($scheme['scheme_subcategory_id'], $scheme['component_id'], $scheme['sub_component_id'], $scheme['scheme_id']); 
                                                                                                    @endphp
                                                                                                    <!-- if both sector present -->
                                                                                                    @if(!empty($scheme['public_range']) && !empty($scheme['private_range']))
                                                                                                        <tr>
                                                                                                            <td class="w-20">
                                                                                                            Public Sector
                                                                                                            </td>
                                                                                                            <td class="w-10">
                                                                                                            {{$scheme['units']}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                            {{$scheme['cost_norms']}}
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-20">
                                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                <input type="text" maxlength="9" class="w-50" name="physical_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                            </td>
                                                                                                            <td class="w-20">
                                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->physical_target, 2)}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                                <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'': $targetsset->remarks }}"/>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="w-20">
                                                                                                            Private Sector
                                                                                                            </td>
                                                                                                            <td class="w-10">{{$scheme['units']}}</td>
                                                                                                            <td class="w-15">
                                                                                                            {{$scheme['cost_norms']}}
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-20">
                                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                <input type="text" maxlength="9" class="w-50" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                                            </td>
                                                                                                            <td class="w-20">
                                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->private_physical_target, 2)}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                                <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'': $targetsset->private_remarks }}"/>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @else
                                                                                                        @if(!empty($scheme['public_range']))
                                                                                                            <tr>
                                                                                                                <td class="w-20">
                                                                                                                Public Sector
                                                                                                                </td>
                                                                                                                <td class="w-10">
                                                                                                                {{$scheme['units']}}
                                                                                                                </td>
                                                                                                                <td class="w-15">
                                                                                                                {{$scheme['cost_norms']}}
                                                                                                                </td>
                                                                                                                
                                                                                                                <td class="w-20">
                                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                    <input type="text" maxlength="9" class="w-50" name="physical_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                                </td>
                                                                                                                <td class="w-20">
                                                                                                                {{number_format((float)$scheme['cost_norms']*(float)$targetsset->physical_target, 2)}}
                                                                                                                </td>
                                                                                                                <td class="w-15">
                                                                                                                    <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'': $targetsset->remarks }}"/>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endif
                                                                                                        @if(!empty($scheme['private_range']))
                                                                                                            <tr>
                                                                                                                <td class="w-20">
                                                                                                                Private Sector
                                                                                                                </td>
                                                                                                                <td class="w-10">{{$scheme['units']}}</td>
                                                                                                                <td class="w-15">
                                                                                                                {{$scheme['cost_norms']}}
                                                                                                                </td>
                                                                                                                
                                                                                                                <td class="w-20">
                                                                                                                    <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                    <input type="text" maxlength="9" class="w-50" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                                                </td>
                                                                                                                <td class="w-20">
                                                                                                                {{number_format((float)$scheme['cost_norms']*(float)$targetsset->private_physical_target, 2)}}
                                                                                                                </td>
                                                                                                                <td class="w-15">
                                                                                                                    <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'': $targetsset->private_remarks }}"/>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endif
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
                                                                                                        <td colspan="5"></td>
                                                                                                    </tr>
                                                                                                    <!-- targets -->
                                                                                                    @php //print_r($scheme);
                                                                                                        $targetsset= $type->fetchtargetstate($scheme['scheme_subcategory_id'], $scheme['component_id'], $scheme['sub_component_id'], $scheme['scheme_id']); 
                                                                                                    @endphp
                                                                                                    <!-- if both sector present -->
                                                                                                    @if(!empty($scheme['public_range']) && !empty($scheme['private_range']))
                                                                                                        <tr>
                                                                                                            <td class="w-20">
                                                                                                            Public Sector
                                                                                                            </td>
                                                                                                            <td class="w-10">
                                                                                                            {{$scheme['units']}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                            {{$scheme['cost_norms']}}
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-20">
                                                                                                                <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                <input type="text" maxlength="9" class="w-50" name="physical_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                            </td>
                                                                                                            <td class="w-20">
                                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->physical_target, 2)}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                                <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'': $targetsset->remarks }}"/>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="w-20">
                                                                                                            Private Sector
                                                                                                            </td>
                                                                                                            <td class="w-10">{{$scheme['units']}}</td>
                                                                                                            <td class="w-15">
                                                                                                            {{$scheme['cost_norms']}}
                                                                                                            </td>
                                                                                                            
                                                                                                            <td class="w-20">
                                                                                                                <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                <input type="text" maxlength="9" class="w-50" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                                            </td>
                                                                                                            <td class="w-20">
                                                                                                            {{number_format((float)$scheme['cost_norms']*(float)$targetsset->private_physical_target, 2)}}
                                                                                                            </td>
                                                                                                            <td class="w-15">
                                                                                                                <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'': $targetsset->private_remarks }}"/>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @else
                                                                                                        @if(!empty($scheme['public_range']))
                                                                                                            <tr>
                                                                                                                <td class="w-20">
                                                                                                                Public Sector
                                                                                                                </td>
                                                                                                                <td class="w-10">
                                                                                                                {{$scheme['units']}}
                                                                                                                </td>
                                                                                                                <td class="w-15">
                                                                                                                {{$scheme['cost_norms']}}
                                                                                                                </td>
                                                                                                                
                                                                                                                <td class="w-20">
                                                                                                                    <input type="hidden" name="target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                    <input type="text" maxlength="9" class="w-50" name="physical_target[]" value="{{ empty($targetsset->physical_target)?'0.00': $targetsset->physical_target }}"/>
                                                                                                                </td>
                                                                                                                <td class="w-20">
                                                                                                                {{number_format((float)$scheme['cost_norms']*(float)$targetsset->physical_target, 2)}}
                                                                                                                </td>
                                                                                                                <td class="w-15">
                                                                                                                    <input type="text" class="w-80" name="remarks[]" value="{{ empty($targetsset->remarks)?'': $targetsset->remarks }}"/>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endif
                                                                                                        @if(!empty($scheme['private_range']))
                                                                                                            <tr>
                                                                                                                <td class="w-20">
                                                                                                                Private Sector
                                                                                                                </td>
                                                                                                                <td class="w-10">{{$scheme['units']}}</td>
                                                                                                                <td class="w-15">
                                                                                                                {{$scheme['cost_norms']}}
                                                                                                                </td>
                                                                                                                
                                                                                                                <td class="w-20">
                                                                                                                    <input type="hidden" name="private_target_id[]" value="{{$targetsset->id}}"/>
                                                                                                                    <input type="text" maxlength="9" class="w-50" name="private_physical_target[]" value="{{empty($targetsset->private_physical_target) ? '0.00' : $targetsset->private_physical_target}}"/>
                                                                                                                </td>
                                                                                                                <td class="w-20">
                                                                                                                {{number_format((float)$scheme['cost_norms']*(float)$targetsset->private_physical_target, 2)}}
                                                                                                                </td>
                                                                                                                <td class="w-15">
                                                                                                                    <input type="text" class="w-80" name="private_remarks[]" value="{{ empty($targetsset->private_remarks)?'': $targetsset->private_remarks }}"/>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endif
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
                                @php if(\Auth::user()->role_id == 1){ @endphp
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
<script>
    $(document).ready(function () {
        $('#example').DataTable();
        $('#year').on('change', function(){
            var id = $(this).val();
            var url = "{{url('/manage-subsidy-state')}}?year="+id;
            window.location = url;             
        });   
        
    });

</script>
@endpush
