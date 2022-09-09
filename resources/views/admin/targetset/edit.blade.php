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
                            <form class="row g-3" method="POST"  enctype="multipart/form-data"  >
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
                                            <option value="{{ $selValue }}">{{ $selValue }}</option>
                                            @endforeach
                                        </select>
                                        <label for="sub_component_name">Financial Year</label>
                                    </div>
                                </div>
                                @forelse($components as $dst) 
                                <div class="col-md-12">
                                    @inject('component', 'App\Models\Component')
                                                                               
                                    {{ $component->fetchsubcomponent($dst->id) }}                                         
                                    
                                    
                                        
                                </div>
                                @empty
                                @endforelse
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="sub_component_id" id="sub_component_id" aria-label="Sub Component Name">
                                            <option value="">Sub Component Name</option>
                                            @forelse($subcomponents as $dst)                                            
                                            <option value="{{ $dst->id }}">{{$dst->sub_component_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="sub_component_id">Sub Component Name</label>
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
                            html+='<option value="'+content.id+'">'+content.category_name+'</option>';
                        }
                        $('#scheme_category_id').empty();
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
                            html+='<option value="'+content.id+'">'+content.subcategory_name+'</option>';
                        }
                        $('#scheme_subcategory_id').empty();
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
                            html+='<option value="'+content.id+'">'+content.component_name+'</option>';
                        }
                        $('#component_id').empty();
                        $('#component_id').html(html);
                    }
                }); 
        });

        $('#component_id').on('change', function(){
            var id = $(this).val();
            $.ajax({
                    type: 'GET',
                    url: "{{route('fetch-sub-components')}}",
                    data: { 'id': id },
                    dataType: "json",
                    success: function(resultData) {
                        var html = '';
                        html+='<option value="">Sub Component Name</option>';
                        if(resultData.message == 'success'){
                            var content = resultData.data;
                            html+='<option value="'+content.id+'">'+content.sub_component_name+'</option>';
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
        var maxFieldsTerms=5;

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
