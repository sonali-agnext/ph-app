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
    <h1>Manage Scheme</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/manage-scheme')}}">Manage Scheme</a></li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">  
             <div class="card">
                <div class="card-body">
                        <h5 class="card-title">Add Scheme</h5>
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
                            <form class="row g-3" method="POST" enctype="multipart/form-data" action="{{ route('add-scheme') }}">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="scheme_subcategory_id" id="scheme_subcategory_id" aria-label="Sub Category Name">
                                            @forelse($scheme_subcategory as $dst)                                            
                                            <option value="{{ $dst->id }}">{{$dst->subcategory_name}}</option>                                            
                                            @empty
                                            @endforelse
                                        </select>
                                        <label for="scheme_category_id">Scheme Sub category Name</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" name="scheme_name" required class="form-control" id="scheme_name" placeholder="Enter Scheme Name" value="">
                                        <label for="scheme_name">Scheme Name</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" name="subsidy" required class="form-control" id="subsidy" placeholder="Enter Subsidy" value="">
                                        <label for="subsidy">Subsidy Range</label>
                                    </div>
                                </div>
                                <hr />
                                <div class="row" style="align-items: center;">
                                    <div class="col-md-12 mb-2">
                                        <p>Subsidy Sector</p>
                                    </div>
                                    <div class="col-md-10 sector-field mb-1" id="sector-field-1">
                                        <div class="row" >
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="sector[]" required class="form-control" id="sector" placeholder="Enter Subsidy Sector" value="">
                                                        <label for="sector">Subsidy Sector Title</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="sector_description[]" required class="form-control" id="sector_description" placeholder="Enter Sector Description" value="">
                                                        <label for="sector_description">Sector Description</label>
                                                    </div>
                                                </div>                                                
                                            </div>
                                    </div>
                                    <div class="col-md-2 mt-30 append-buttons">
                                        <div class="clearfix">
                                        <button type="button" id="add-sector-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" id="remove-sector-button" class="btn btn-secondary float-left text-uppercase ml-1" disabled="disabled"><i class="bi bi-dash"></i>
                                        </button>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <div class="row" style="align-items: center;">
                                    <div class="col-md-12 mb-2">
                                        <p>Terms</p>
                                    </div>
                                    <div class="col-md-10 terms-field mb-1" id="terms-field-1">
                                        <div class="row" >
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" name="terms[]" required class="form-control" id="terms" placeholder="Enter Terms" value="">
                                                    <label for="terms">Title</label>
                                                </div>
                                            </div>                                              
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-30 append-buttons">
                                        <div class="clearfix">
                                        <button type="button" id="add-terms-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" id="remove-terms-button" class="btn btn-secondary float-left text-uppercase ml-1" disabled="disabled"><i class="bi bi-dash"></i>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" name="cost_norms" required class="form-control" id="cost_norms" placeholder="Enter Cost Norms" value="">
                                        <label for="cost_norms">Cost Norms</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea name="detailed_description" required class="form-control" id="detailed_description" placeholder="Enter Detailed Description" value=""></textarea>
                                        <label for="detailed_description">Detailed Description</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="file" name="scheme_image" required class="form-control" id="scheme_image" value="" >
                                        <label for="scheme_image">Scheme Image</label>
                                    </div>
                                </div>

                                <div class="row" style="align-items: center;">
                                    <div class="col-md-12 pt-3 mb-2">
                                        <p>Video</p>
                                    </div>
                                    <div class="col-md-10 video-field mb-1" id="video-field-1">
                                        <div class="row" >
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="url" name="video[]" required class="form-control" id="video" placeholder="Enter Cost Norms" value="">
                                                        <label for="video">Video URL</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" name="title[]" required class="form-control" id="title" placeholder="Enter Title" value="">
                                                        <label for="title">Title</label>
                                                    </div>
                                                </div>                                                
                                            </div>
                                    </div>
                                    <div class="col-md-2 mt-30 append-buttons">
                                        <div class="clearfix">
                                        <button type="button" id="add-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" id="remove-button" class="btn btn-secondary float-left text-uppercase ml-1" disabled="disabled"><i class="bi bi-dash"></i>
                                        </button>
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
            countSector = totalFields() + 1;
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