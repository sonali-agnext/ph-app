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
</style>
<div class="pagetitle">
    <h1>Manage Scheme Crops/Items</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/manage-scheme')}}">Manage Scheme Crops/Items</a></li>
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
                        <h5 class="card-title">Edit Scheme</h5>
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
                            <!-- Floating Labels Form -->
                            <form class="row g-3" method="POST"  enctype="multipart/form-data"  action="{{ route('update-scheme',['id' => $scheme->id]) }}">
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
                                            <option @if($scheme->year == $selValue) selected @endif value="{{ $selValue }}">{{ $selValue }}</option>
                                            @endforeach
                                        </select>
                                        <label for="sub_component_name">Financial Year</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="govt_id" required id="govt_id" aria-label="Parent Scheme Name">
                                            <option value="">Parent Scheme Name</option>
                                            @forelse($govt_schemes as $dst)                                            
                                            <option @if($scheme->govt_id == $dst->id) selected @endif value="{{ $dst->id }}">{{$dst->govt_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="govt_id">Parent Scheme Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="scheme_category_id" required id="scheme_category_id" aria-label="Scheme Category Name">
                                            <option value="">Scheme Category Name</option>                                            
                                            @forelse($scheme_category as $dst)                                            
                                            <option @if($scheme->category_id == $dst->id) selected @endif value="{{ $dst->id }}">{{$dst->category_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="scheme_category_id">Scheme Category Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="scheme_subcategory_id" required id="scheme_subcategory_id" aria-label="Component Type">
                                            <option value="">Component Type</option>
                                            @forelse($scheme_subcategory as $dst)                                            
                                            <option @if($scheme->scheme_subcategory_id == $dst->id) selected @endif value="{{ $dst->id }}">{{$dst->subcategory_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="scheme_subcategory_id">Component Type</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="component_id" id="component_id" aria-label="Component Name">
                                            <option value="">Component Name</option>
                                            @forelse($components as $dst)                                            
                                            <option @if($scheme->component_id == $dst->id) selected @endif value="{{ $dst->id }}">{{$dst->component_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="component_id">Component Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="sub_component_id" id="sub_component_id" aria-label="Sub Component Name">
                                            <option value="">Sub Component Name</option>
                                            @forelse($subcomponents as $dst)                                            
                                            <option @if($scheme->sub_component_id == $dst->id) selected @endif value="{{ $dst->id }}">{{$dst->sub_component_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="sub_component_id">Sub Component Name</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" name="scheme_name" required class="form-control" id="scheme_name" placeholder="Enter Scheme Name" value="{{ $scheme->scheme_name}}">
                                        <label for="scheme_name">Crop/Item Name</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="status" id="status" aria-label="Scheme Status">
                                            <option @if($scheme->status) selected @endif value="1">True</option>
                                            <option @if($scheme->status == 0) selected @endif value="0">False</option>                                            
                                        </select>
                                        <label for="status">Scheme Status</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="non_project_based" id="non_project_based" aria-label="Scheme Based">
                                            <option @if($scheme->non_project_based == "Non-Project Based") selected @endif value="Non-Project Based">Non-Project Based</option>
                                            <option @if($scheme->non_project_based == "Project Based") selected @endif value="Project Based">Project Based</option>
                                        </select>
                                        <label for="non_project_based">Scheme Based</label>
                                    </div>
                                </div>

                                <!-- <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" name="subsidy" required class="form-control" id="subsidy" placeholder="Enter Subsidy For ex: 40, 40-100,0" value="{{ $scheme->subsidy}}">
                                        <label for="subsidy">Subsidy Range</label>
                                    </div>
                                </div> -->
                                <hr />
                                <div class="row" style="align-items: center;">
                                    <div class="col-md-12 mb-2">
                                        <p>Subsidy Sector</p>
                                    </div>
                                    
                                    <div class="col-md-12 sector-field mb-1" id="sector-field-1">
                                        <div class="row" >
                                            <div class="col-md-6 mb-1">
                                                <div class="form-floating">
                                                    <input type="text" pattern="[0-9]+" title="Numbers Only" maxlength="3" name="public_range" class="form-control" placeholder="Enter Public Sector Range" value="{{!empty($scheme->public_range)?$scheme->public_range:0}}">
                                                    <label for="public_range">Public Sector Range</label>
                                                </div>
                                            </div>
                                                 
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" pattern="[0-9]+" title="Numbers Only" maxlength="3" name="private_range" class="form-control" placeholder="Enter Private Sector Range" value="{{!empty($scheme->private_range)?$scheme->private_range:0}}">
                                                    <label for="private_range">Private Sector Range</label>
                                                </div>
                                            </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="form-floating">
                                                        <input type="text" name="public_sector" class="form-control" placeholder="Enter Public Sector Description" value="{{!empty($scheme->public_sector)?$scheme->public_sector:''}}">
                                                        <label for="public_sector">Public Sector Description</label>
                                                    </div>
                                                </div>
                                                 
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="private_sector" class="form-control" placeholder="Enter Private Sector Description" value="{{!empty($scheme->private_sector)?$scheme->private_sector:''}}">
                                                        <label for="private_sector">Private Sector Description</label>
                                                    </div>
                                                </div> 
                                    </div>
                                    <!-- <div class="col-md-2 mt-30 append-buttons">
                                        <div class="clearfix">
                                        <button type="button" id="add-sector-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" id="remove-sector-button" class="btn btn-secondary float-left text-uppercase ml-1 {{ !empty($sector_len) ? 'shadow-sm' :''}}" @if(empty($sector_len)) disabled="disabled" @endif><i class="bi bi-dash"></i>
                                        </button>
                                        </div>
                                    </div> -->
                                </div>

                                <hr />

                                <div class="row" style="align-items: center;">
                                    <div class="col-md-12 mb-2">
                                        <p>Required Documents</p>
                                    </div>
                                @php $terms = !empty($scheme->terms)?json_decode($scheme->terms):[]; $term_len=count($terms); @endphp
                                @forelse($terms as $tkey => $term)
                                    <div class="col-md-10 terms-field mb-1" id="terms-field-{{ ($tkey+1) }}">
                                        <div class="row" >
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" name="terms[]"  class="form-control" id="terms" placeholder="Enter Terms" value="{{$term}}">
                                                    <label for="terms">Title</label>
                                                </div>
                                            </div>                                              
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-10 terms-field mb-1" id="terms-field-1">
                                        <div class="row" >
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" name="terms[]"  class="form-control" id="terms" placeholder="Enter Terms" value="">
                                                    <label for="terms">Title</label>
                                                </div>
                                            </div>                                              
                                        </div>
                                    </div>
                                @endforelse
                                    <div class="col-md-2 mt-30 append-buttons">
                                        <div class="clearfix">
                                        <button type="button" id="add-terms-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" id="remove-terms-button" class="btn btn-secondary float-left text-uppercase ml-1 {{ !empty($term_len) ? 'shadow-sm' :''}}" @if(empty($term_len)) disabled="disabled" @endif><i class="bi bi-dash"></i>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" name="cost_norms" pattern="^\d*(\.\d{0,2})?$" required class="form-control" id="cost_norms" placeholder="Enter Cost Norms" value="{{$scheme->cost_norms}}">
                                        <label for="cost_norms">Cost Norms(ex: 10 thousand = 10000.00)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="units" id="units" aria-label="Units">
                                            <option value="">--Select Unit Type--</option>
                                            <option @if($scheme->units == "Quintals") selected @endif value="Quintals">Quintals</option>
                                            <option @if($scheme->units == "Kg") selected @endif value="Kg">Kg</option>
                                            <option @if($scheme->units == "Ltr") selected @endif value="Ltr">Ltr</option>
                                            <option @if($scheme->units == "gms") selected @endif value="gms">gms</option>
                                            <option @if($scheme->units == "Ha.") selected @endif value="Ha.">Ha.</option>
                                            <option @if($scheme->units == "No.s") selected @endif value="No.s">No.s</option>
                                            <option @if($scheme->units == "Project") selected @endif value="Project">Project</option>
                                            <option @if($scheme->units == "Sq. Mtr") selected @endif value="Sq. Mtr">Sq. Mtr</option>
                                            <option @if($scheme->units == "One Unit") selected @endif value="One Unit">One Unit</option>
                                            <option @if($scheme->units == "Set") selected @endif value="Set">Set</option>
                                            <option @if($scheme->units == "Colony") selected @endif value="Colony">Colony</option>
                                            <option @if($scheme->units == "Hive") selected @endif value="Hive">Hive</option>
                                            <option @if($scheme->units == "MT") selected @endif value="MT">MT(Metric Ton)</option>
                                            <option @if($scheme->units == "Day") selected @endif value="Day"> Day</option>

                                        </select>
                                        <label for="units">Units</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea name="detailed_description" class="form-control" id="detailed_description" placeholder="Enter Detailed Description">{{$scheme->detailed_description}}</textarea>
                                        <label for="detailed_description">Detailed Description</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="file" name="scheme_image" @if(!empty($scheme->scheme_image)) @else  @endif class="form-control" id="scheme_image" value="" >
                                        <label for="scheme_image">Scheme Image</label>
                                    </div>
                                    <div>
                                        @if(!empty($scheme->scheme_image))
                                        <img src="{{asset('storage/scheme-images/'.$scheme->scheme_image)}}" width="100" />
                                        @endif
                                    </div>
                                </div>

                                <div class="row" style="align-items: center;">
                                    <div class="col-md-12 pt-3 mb-2">
                                        <p>Video</p>
                                    </div>
                                    @php $videos = !empty($scheme->videos)?json_decode($scheme->videos):[]; $video_len=count($videos); @endphp
                                    @php $titles = !empty($scheme->videos_title)?json_decode($scheme->videos_title):[]; $title_len=count($titles); @endphp
                                    @forelse($videos as $vkey => $video)
                                    <div class="col-md-10 video-field mb-1" id="video-field-{{($vkey+1)}}">
                                        <div class="row" >
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="url" name="video[]"  class="form-control" id="video" placeholder="Enter Cost Norms" value="{{$video}}">
                                                    <label for="video">Video URL</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="title[]"  class="form-control" id="title" placeholder="Enter Title" value="{{ $titles[$vkey]}}">
                                                    <label for="title">Title</label>
                                                </div>
                                            </div>                                                
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-md-10 video-field mb-1" id="video-field-1">
                                        <div class="row" >
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="url" name="video[]"  class="form-control" id="video" placeholder="Enter Cost Norms" value="">
                                                        <label for="video">Video URL</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="title[]"  class="form-control" id="title" placeholder="Enter Title" value="">
                                                        <label for="title">Title</label>
                                                    </div>
                                                </div>                                                
                                            </div>
                                    </div>
                                    @endforelse
                                    <div class="col-md-2 mt-30 append-buttons">
                                        <div class="clearfix">
                                        <button type="button" id="add-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" id="remove-button" class="btn btn-secondary float-left text-uppercase ml-1 {{ !empty($video_len) ? 'shadow-sm' :''}}" @if(empty($video_len)) disabled="disabled" @endif><i class="bi bi-dash"></i>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- <p class="text-warning">Note* If Scheme Based is changed then need to add file which is required otherwise reload the page to previous stage.</p> -->
                                <div class="col-md-6 mt-1">
                                    <div class="form-floating">
                                        <input type="file" name="dpr_upload" class="form-control" id="dpr_upload" value="" >
                                        <label for="dpr_upload">DPR Upload</label>
                                    </div>
                                    @if(!empty($scheme->dpr_upload))
                                        <a href="{{asset('storage/scheme-doc/'.$scheme->dpr_upload)}}" target="_blank" width="100">View DPR</a>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-1">
                                    <div class="form-floating">
                                        <input type="file" name="self_upload" class="form-control" id="self_upload" value="" >
                                        <label for="self_upload">Application Form Upload</label>
                                    </div>
                                    @if(!empty($scheme->self_upload))
                                        <a href="{{asset('storage/scheme-doc/'.$scheme->self_upload)}}" target="_blank" width="100">View Form</a>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mt-1">
                                        <div class="form-check form-switch"> 
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="is_featured" @if($scheme->is_featured == "1") checked="" @endif value="1"> 
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Featured Scheme</label></div>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                                </div>
                            </form><!-- End floating Labels Form -->
                                       
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
        var year =$('#year').val();
        $('#govt_id').on('change', function(){
            var id = $(this).val();
            $.ajax({
                    type: 'GET',
                    url: "{{route('fetch-scheme-category')}}",
                    data: { 'id': id },
                    dataType: "json",
                    success: function(resultData) {
                        var html = '';
                        html+='<option value="">Scheme Category Name</option>';
                        if(resultData.message == 'success'){
                            var content = resultData.data;
                            console.log(content.id);
                            $.each(content, function(key,val) {
                                html+='<option value="'+val.id+'">'+val.category_name+'</option>';      
                            });
                        }
                        $('#scheme_category_id').empty();
                        $('#scheme_subcategory_id').empty();
                        $('#sub_component_id').empty();
                        $('#component_id').empty();
                        $('#scheme_category_id').html(html);
                    }
                }); 
        });   
        $('#scheme_category_id').on('change', function(){
            var id = $(this).val();
            
            $.ajax({
                    type: 'GET',
                    url: "{{route('fetch-component-type')}}",
                    data: { 'id': id },
                    dataType: "json",
                    success: function(resultData) {
                        var html = '';
                        html+='<option value="">Component Type</option>';
                        if(resultData.message == 'success'){
                            var content = resultData.data;
                            $.each(content, function(key,val) {
                                html+='<option value="'+val.id+'">'+val.subcategory_name+'</option>';      
                            });
                        }
                        $('#scheme_subcategory_id').empty();
                        $('#sub_component_id').empty();
                        $('#component_id').empty();
                        $('#scheme_subcategory_id').html(html);
                    }
                }); 
        });   
        $('#scheme_subcategory_id').on('change', function(){
            var id = $(this).val();
            $.ajax({
                    type: 'GET',
                    url: "{{route('fetch-components')}}",
                    data: { 'id': id },
                    dataType: "json",
                    success: function(resultData) {
                        var html = '';
                        html+='<option value="">Component Name</option>';
                        if(resultData.message == 'success'){
                            var content = resultData.data;
                            $.each(content, function(key,val) {
                                html+='<option value="'+val.id+'">'+val.component_name+'</option>';      
                            }); 
                        }
                        $('#component_id').empty();
                        $('#component_id').html(html);
                    }
                }); 
        });

        // $("#non_project_based").on('change', function(){
        //     var p_value = $(this).val();
        //     console.log(p_value);
        //     if(p_value == 'Non-Project Based'){
        //         $('#dpr_upload').removeAttr('required');
        //         $('#dpr_upload').val('');
        //         $('#self_upload').attr('required',true);
        //     }else{
        //         $('#dpr_upload').attr('required',true);
        //         $('#self_upload').val('');
        //         $('#self_upload').removeAttr('required');
        //     }
        // });

        $('#component_id').on('change', function(){
            var id = $(this).val();
            $.ajax({
                    type: 'GET',
                    url: "{{route('fetch-sub-components')}}",
                    data: { 'id': id, 'year': year },
                    dataType: "json",
                    success: function(resultData) {
                        var html = '';
                        html+='<option value="">Sub Component Name</option>';
                        if(resultData.message == 'success'){
                            var content = resultData.data;
                            $.each(content, function(key,val) {
                                html+='<option value="'+val.id+'">'+val.sub_component_name+'</option>';      
                            });
                        }
                        $('#sub_component_id').empty();
                        $('#sub_component_id').html(html);
                    }
                }); 
        });
        $('#year').on('change', function(){
            var id = $('#component_id').val();
            year = $(this).val();
            $.ajax({
                    type: 'GET',
                    url: "{{route('fetch-sub-components')}}",
                    data: { 'id': id, 'year': year },
                    dataType: "json",
                    success: function(resultData) {
                        var html = '';
                        html+='<option value="">Sub Component Name</option>';
                        if(resultData.message == 'success'){
                            var content = resultData.data;
                            $.each(content, function(key,val) {
                                html+='<option value="'+val.id+'">'+val.sub_component_name+'</option>';      
                            });
                        }
                        $('#sub_component_id').empty();
                        $('#sub_component_id').html(html);
                    }
                }); 
        });
    });

    $(document).ready(function() {
        var buttonAdd = $("#add-button");
        var buttonRemove = $("#remove-button");
        var className = ".video-field";
        var count = 0;
        var field = "";
        var maxFields=5;

        function totalFields() {
            return $(className).length;
        }

        function addNewField() {
            count = totalFields() + 1;
            field = $("#video-field-1").clone();
            field.attr("id", "video-field-" + count);
            field.children("label").text("Field " + count);
            field.find("input").val("");
            $(className + ":last").after($(field));
        }

        function removeLastField() {
            if (totalFields() > 1) {
            $(className + ":last").remove();
            }
        }

        function enableButtonRemove() {
            if (totalFields() === 2) {
            buttonRemove.removeAttr("disabled");
            buttonRemove.addClass("shadow-sm");
            }
        }

        function disableButtonRemove() {
            if (totalFields() === 1) {
            buttonRemove.attr("disabled", "disabled");
            buttonRemove.removeClass("shadow-sm");
            }
        }

        function disableButtonAdd() {
            if (totalFields() === maxFields) {
            buttonAdd.attr("disabled", "disabled");
            buttonAdd.removeClass("shadow-sm");
            }
        }

        function enableButtonAdd() {
            if (totalFields() === (maxFields - 1)) {
            buttonAdd.removeAttr("disabled");
            buttonAdd.addClass("shadow-sm");
            }
        }

        buttonAdd.click(function() {
            addNewField();
            enableButtonRemove();
            disableButtonAdd();
        });

        buttonRemove.click(function() {
            removeLastField();
            disableButtonRemove();
            enableButtonAdd();
        });

        // sector
        var buttonSectorAdd = $("#add-sector-button");
        var buttonSectorRemove = $("#remove-sector-button");
        var classNameSector = ".sector-field";
        var countSector = 0;
        var fieldSector = "";
        var maxFieldsSector=5;

        function totalSectorFields() {
            return $(classNameSector).length;
        }

        function addNewSectorField() {
            countSector = totalSectorFields() + 1;
            fieldSector = $("#sector-field-1").clone();
            fieldSector.attr("id", "sector-field-" + countSector);
            fieldSector.children("label").text("Field " + countSector);
            fieldSector.find("input").val("");
            $(classNameSector + ":last").after($(fieldSector));
        }

        function removeLastSectorField() {
            if (totalSectorFields() > 1) {
            $(classNameSector + ":last").remove();
            }
        }

        function enableButtonSectorRemove() {
            if (totalSectorFields() === 2) {
                buttonSectorRemove.removeAttr("disabled");
                buttonSectorRemove.addClass("shadow-sm");
            }
        }

        function disableButtonSectorRemove() {
            if (totalSectorFields() === 1) {
                buttonSectorRemove.attr("disabled", "disabled");
                buttonSectorRemove.removeClass("shadow-sm");
            }
        }

        function disableButtonSectorAdd() {
            if (totalSectorFields() === maxFieldsSector) {
                buttonSectorAdd.attr("disabled", "disabled");
                buttonSectorAdd.removeClass("shadow-sm");
            }
        }

        function enableButtonSectorAdd() {
            if (totalSectorFields() === (maxFieldsSector - 1)) {
                buttonSectorAdd.removeAttr("disabled");
                buttonSectorAdd.addClass("shadow-sm");
            }
        }

        buttonSectorAdd.click(function() {
            addNewSectorField();
            enableButtonSectorRemove();
            disableButtonSectorAdd();
        });

        buttonSectorRemove.click(function() {
            removeLastSectorField();
            disableButtonSectorRemove();
            enableButtonSectorAdd();
        });

        //terms
        var buttonAddTerms = $("#add-terms-button");
        var buttonRemoveTerms = $("#remove-terms-button");
        var classNameTerms = ".terms-field";
        var countTerms = 0;
        var fieldTerms = "";
        var maxFieldsTerms=30;

        function totalTermsFields() {
            return $(classNameTerms).length;
        }

        function addNewTermsField() {
            countTerms = totalTermsFields() + 1;
            fieldTerms = $("#terms-field-1").clone();
            fieldTerms.attr("id", "terms-field-" + countTerms);
            fieldTerms.children("label").text("Field " + countTerms);
            fieldTerms.find("input").val("");
            $(classNameTerms + ":last").after($(fieldTerms));
        }

        function removeLastTermsField() {
            if (totalTermsFields() > 1) {
            $(classNameTerms + ":last").remove();
            }
        }

        function enableButtonTermsRemove() {
            if (totalTermsFields() === 2) {
                buttonRemoveTerms.removeAttr("disabled");
                buttonRemoveTerms.addClass("shadow-sm");
            }
        }

        function disableButtonTermsRemove() {
            if (totalTermsFields() === 1) {
                buttonRemoveTerms.attr("disabled", "disabled");
                buttonRemoveTerms.removeClass("shadow-sm");
            }
        }

        function disableButtonTermsAdd() {
            if (totalTermsFields() === maxFieldsTerms) {
                buttonAddTerms.attr("disabled", "disabled");
                buttonAddTerms.removeClass("shadow-sm");
            }
        }

        function enableButtonTermsAdd() {
            if (totalTermsFields() === (maxFieldsTerms - 1)) {
                buttonAddTerms.removeAttr("disabled");
                buttonAddTerms.addClass("shadow-sm");
            }
        }

        buttonAddTerms.click(function() {
            addNewTermsField();
            enableButtonTermsRemove();
            disableButtonTermsAdd();
        });

        buttonRemoveTerms.click(function() {
            removeLastTermsField();
            disableButtonTermsRemove();
            enableButtonTermsAdd();
        });

    });
</script>
@endpush
