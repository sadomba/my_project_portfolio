<!-- 
expose component model to current view
e.g $arrDataFromDb = $comp_model->fetchData(); //function name
-->
@inject('comp_model', 'App\Models\ComponentsData')
<?php
    $pageTitle = "Edit User"; //set dynamic page title
?>
@extends($layout)
@section('title', $pageTitle)
@section('content')
<section class="page" data-page-type="edit" data-page-url="{{ url()->full() }}">
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
                        <div class="h5 font-weight-bold text-primary">Edit User</div>
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
                <div class="col-md-9 comp-grid " >
                    <div  class="card card-1 border rounded page-content" >
                        <!--[form-start]-->
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("user/edit/$rec_id"); ?>" method="post">
                        <!--[form-content-start]-->
                        @csrf
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="id">Id <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-id-holder" class=" ">
                                            <input id="ctrl-id" data-field="id"  value="<?php  echo $data['id']; ?>" type="number" placeholder="Enter Id" step="any"  required="" name="id"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="username">Username <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-username-holder" class=" ">
                                            <input id="ctrl-username" data-field="username"  value="<?php  echo $data['username']; ?>" type="text" placeholder="Enter Username"  required="" name="username"  data-url="componentsdata/user_username_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                            <div class="check-status"></div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="picture">Picture </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-picture-holder" class=" ">
                                            <div class="dropzone " input="#ctrl-picture" fieldname="picture" uploadurl="{{ url('fileuploader/upload/picture') }}"    data-multiple="false" dropmsg="Choose files or drop files here"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="3" maximum="1">
                                                <input name="picture" id="ctrl-picture" data-field="picture" class="dropzone-input form-control" value="<?php  echo $data['picture']; ?>" type="text"  />
                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                            </div>
                                        </div>
                                        <?php Html :: uploaded_files_list($data['picture'], '#ctrl-picture'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="phone">Phone </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-phone-holder" class=" ">
                                            <input id="ctrl-phone" data-field="phone"  value="<?php  echo $data['phone']; ?>" type="text" placeholder="Enter Phone"  name="phone"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="user_role_id">User Role Id </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-user_role_id-holder" class=" ">
                                            <select  id="ctrl-user_role_id" data-field="user_role_id" name="user_role_id"  placeholder="Select a value ..."    class="form-select" >
                                            <option value="">Select a value ...</option>
                                            <?php
                                                $options = $comp_model->role_id_option_list() ?? [];
                                                foreach($options as $option){
                                                $value = $option->value;
                                                $label = $option->label ?? $value;
                                                $selected = ( $value == $data['user_role_id'] ? 'selected' : null );
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                            <?php echo $label; ?>
                                            </option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="account_status">Account Status </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-account_status-holder" class=" ">
                                            <input id="ctrl-account_status" data-field="account_status"  value="<?php  echo $data['account_status']; ?>" type="text" placeholder="Enter Account Status"  name="account_status"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-ajax-status"></div>
                        <!--[form-content-end]-->
                        <!--[form-button-start]-->
                        <div class="form-group text-center">
                            <button class="btn btn-primary" type="submit">
                            Update
                            <i class="material-icons">send</i>
                            </button>
                        </div>
                        <!--[form-button-end]-->
                    </form>
                    <!--[form-end]-->
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
