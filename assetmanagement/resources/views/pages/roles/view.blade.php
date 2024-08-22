<!-- 
expose component model to current view
e.g $arrDataFromDb = $comp_model->fetchData(); //function name
-->
@inject('comp_model', 'App\Models\ComponentsData')
<?php
    //check if current user role is allowed access to the pages
    $can_add = $user->canAccess("roles/add");
    $can_edit = $user->canAccess("roles/edit");
    $can_view = $user->canAccess("roles/view");
    $can_delete = $user->canAccess("roles/delete");
    $pageTitle = "Role Details"; //set dynamic page title
?>
@extends($layout)
@section('title', $pageTitle)
@section('content')
<section class="page" data-page-type="view" data-page-url="{{ url()->full() }}">
    <?php
        if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3" >
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto  back-btn-col" >
                    <a class="back-btn btn " href="{{ url()->previous() }}" >
                        <i class="material-icons">arrow_back</i>                                
                    </a>
                </div>
                <div class="col  " >
                    <div class="">
                        <div class="h5 font-weight-bold text-primary">Role Details</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
    <div  class="" >
        <div class="container">
            <div class="row ">
                <div class="col comp-grid " >
                    <div  class=" page-content" >
                        <?php
                            if($data){
                            $rec_id = ($data['role_id'] ? urlencode($data['role_id']) : null);
                        ?>
                        <div id="page-main-content" class=" px-3 mb-3">
                            <div class="page-data">
                                <!--PageComponentStart-->
                                <div class="mb-3 row row justify-content-start g-0">
                                    <div class="col-12">
                                        <div class="bg-light mb-1 card-1 p-2 border rounded">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <small class="text-muted">Role Id</small>
                                                    <div class="fw-bold">
                                                        <?php echo  $data['role_id'] ; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="bg-light mb-1 card-1 p-2 border rounded">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <small class="text-muted">Role Name</small>
                                                    <div class="fw-bold">
                                                        <?php echo  $data['role_name'] ; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--PageComponentEnd-->
                                <div class="d-flex align-items-center gap-2">
                                    <?php if($can_edit){ ?>
                                    <a class="btn btn-sm btn-success has-tooltip "   title="Edit" href="<?php print_link("roles/edit/$rec_id"); ?>" >
                                    <i class="material-icons">edit</i> Edit
                                </a>
                                <?php } ?>
                                <?php if($can_delete){ ?>
                                <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal" title="Delete" href="<?php print_link("roles/delete/$rec_id?redirect=roles"); ?>" >
                                <i class="material-icons">delete_sweep</i> Delete
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                    }
                    else{
                ?>
                <!-- Empty Record Message -->
                <div class="text-muted p-3">
                    <i class="material-icons">block</i> No Record Found
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
</section>
@endsection
<!-- Page custom css -->
@section('pagecss')
<style>

</style>
@endsection
<!-- Page custom js -->
@section('pagejs')
<script>
    <!--pageautofill-->
$(document).ready(function(){
	// custom javascript | jquery codes
});

</script>
@endsection
