 <!-- 
expose component model to current view
e.g $arrDataFromDb = $comp_model->fetchData(); //function name
-->
@inject('comp_model', 'App\Models\ComponentsData')
<?php 
    $pageTitle = "Home"; // set dynamic page title
?>
@extends($layout)
@section('title', $pageTitle)
@section('content')
<div>
    <div  class="bg-light p-3 mb-3" >
        <div class="container-fluid">
            <div class="row ">
                <div class="col comp-grid " >
                    <div class="">
                        <div class="h5 font-weight-bold">Home</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="mb-3" >
        <div class="container-fluid">
            <div class="row ">
                <div class="col comp-grid " >
                    <?php $rec_count = $comp_model->getcount_assetregister();  ?>
                    <a class="animated zoomIn record-count alert alert-primary"  href='<?php print_link("assetregister") ?>' >
                    <div class="row gutter-sm align-items-center">
                        <div class="col-auto" style="opacity: 1;">
                            <i class="material-icons">extension</i>
                        </div>
                        <div class="col">
                            <div class="flex-column justify-content align-center">
                                <div class="title">Asset Register</div>
                                <small class="">Total Assets</small>
                            </div>
                            <h2 class="value"><?php echo $rec_count; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4 comp-grid " >
            </div>
        </div>
    </div>
</div>
<div  class="mb-3" >
    <div class="container-fluid">
        <div class="row ">
            <div class="col comp-grid " >
                <?php $rec_count = $comp_model->getcount_issues();  ?>
                <a class="animated zoomIn record-count alert alert-primary"  href='<?php print_link("issues") ?>' >
                <div class="row gutter-sm align-items-center">
                    <div class="col-auto" style="opacity: 1;">
                        <i class="material-icons">extension</i>
                    </div>
                    <div class="col">
                        <div class="flex-column justify-content align-center">
                            <div class="title">Issues</div>
                            <small class="">Total assets with issues</small>
                        </div>
                        <h2 class="value"><?php echo $rec_count; ?></h2>
                    </div>
                </div>
            </a>
            <?php $rec_count = $comp_model->getcount_moved();  ?>
            <a class="animated zoomIn record-count alert alert-primary"  href='<?php print_link("moved") ?>' >
            <div class="row gutter-sm align-items-center">
                <div class="col-auto" style="opacity: 1;">
                    <i class="material-icons">extension</i>
                </div>
                <div class="col">
                    <div class="flex-column justify-content align-center">
                        <div class="title">Moved</div>
                        <small class="">Total Moved</small>
                    </div>
                    <h2 class="value"><?php echo $rec_count; ?></h2>
                </div>
            </div>
        </a>
        <?php $rec_count = $comp_model->getcount_desposed();  ?>
        <a class="animated zoomIn record-count alert alert-primary"  href='<?php print_link("desposed") ?>' >
        <div class="row gutter-sm align-items-center">
            <div class="col-auto" style="opacity: 1;">
                <i class="material-icons">extension</i>
            </div>
            <div class="col">
                <div class="flex-column justify-content align-center">
                    <div class="title">Desposed</div>
                    <small class="">Total Desposed</small>
                </div>
                <h2 class="value"><?php echo $rec_count; ?></h2>
            </div>
        </div>
    </a>
</div>
</div>
</div>
</div>
</div>
@endsection
<!-- Page custom css -->
@section('pagecss')
<style>
</style>
@endsection
<!-- Page custom js -->
@section('pagejs')
<script>
    $(document).ready(function(){
    // custom javascript | jquery codes
    });
</script>
@endsection
