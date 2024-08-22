<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



	Route::get('', 'IndexController@index')->name('index')->middleware(['redirect.to.home']);
	Route::get('index/login', 'IndexController@login')->name('login');
	
	Route::post('auth/login', 'AuthController@login')->name('auth.login');
	Route::any('auth/logout', 'AuthController@logout')->name('logout')->middleware(['auth']);

	Route::get('auth/accountcreated', 'AuthController@accountcreated')->name('accountcreated');
	Route::get('auth/accountpending', 'AuthController@accountpending')->name('accountpending');
	Route::get('auth/accountblocked', 'AuthController@accountblocked')->name('accountblocked');
	Route::get('auth/accountinactive', 'AuthController@accountinactive')->name('accountinactive');


	
	Route::get('index/register', 'AuthController@register')->name('auth.register')->middleware(['redirect.to.home']);
	Route::post('index/register', 'AuthController@register_store')->name('auth.register_store');
		
	Route::post('auth/login', 'AuthController@login')->name('auth.login');
	Route::get('auth/password/forgotpassword', 'AuthController@showForgotPassword')->name('password.forgotpassword');
	Route::post('auth/password/sendemail', 'AuthController@sendPasswordResetLink')->name('password.email');
	Route::get('auth/password/reset', 'AuthController@showResetPassword')->name('password.reset.token');
	Route::post('auth/password/resetpassword', 'AuthController@resetPassword')->name('password.resetpassword');
	Route::get('auth/password/resetcompleted', 'AuthController@passwordResetCompleted')->name('password.resetcompleted');
	Route::get('auth/password/linksent', 'AuthController@passwordResetLinkSent')->name('password.resetlinksent');
	

/**
 * All routes which requires auth
 */
Route::middleware(['auth', 'rbac'])->group(function () {
		
	Route::get('home', 'HomeController@index')->name('home');

	

/* routes for AssetRegister Controller */
	Route::get('assetregister', 'AssetRegisterController@index')->name('assetregister.index');
	Route::get('assetregister/index/{filter?}/{filtervalue?}', 'AssetRegisterController@index')->name('assetregister.index');	
	Route::get('assetregister/view/{rec_id}', 'AssetRegisterController@view')->name('assetregister.view');	
	Route::get('assetregister/add', 'AssetRegisterController@add')->name('assetregister.add');
	Route::post('assetregister/add', 'AssetRegisterController@store')->name('assetregister.store');
		
	Route::any('assetregister/edit/{rec_id}', 'AssetRegisterController@edit')->name('assetregister.edit');	
	Route::get('assetregister/delete/{rec_id}', 'AssetRegisterController@delete');

/* routes for Audits Controller */
	Route::get('audits', 'AuditsController@index')->name('audits.index');
	Route::get('audits/index/{filter?}/{filtervalue?}', 'AuditsController@index')->name('audits.index');	
	Route::get('audits/view/{rec_id}', 'AuditsController@view')->name('audits.view');

/* routes for Desposed Controller */
	Route::get('desposed', 'DesposedController@index')->name('desposed.index');
	Route::get('desposed/index/{filter?}/{filtervalue?}', 'DesposedController@index')->name('desposed.index');	
	Route::get('desposed/view/{rec_id}', 'DesposedController@view')->name('desposed.view');	
	Route::get('desposed/add', 'DesposedController@add')->name('desposed.add');
	Route::post('desposed/add', 'DesposedController@store')->name('desposed.store');
		
	Route::any('desposed/edit/{rec_id}', 'DesposedController@edit')->name('desposed.edit');	
	Route::get('desposed/delete/{rec_id}', 'DesposedController@delete');

/* routes for Issues Controller */
	Route::get('issues', 'IssuesController@index')->name('issues.index');
	Route::get('issues/index/{filter?}/{filtervalue?}', 'IssuesController@index')->name('issues.index');	
	Route::get('issues/view/{rec_id}', 'IssuesController@view')->name('issues.view');	
	Route::get('issues/add', 'IssuesController@add')->name('issues.add');
	Route::post('issues/add', 'IssuesController@store')->name('issues.store');
		
	Route::any('issues/edit/{rec_id}', 'IssuesController@edit')->name('issues.edit');	
	Route::get('issues/delete/{rec_id}', 'IssuesController@delete');

/* routes for Moved Controller */
	Route::get('moved', 'MovedController@index')->name('moved.index');
	Route::get('moved/index/{filter?}/{filtervalue?}', 'MovedController@index')->name('moved.index');	
	Route::get('moved/view/{rec_id}', 'MovedController@view')->name('moved.view');	
	Route::get('moved/add', 'MovedController@add')->name('moved.add');
	Route::post('moved/add', 'MovedController@store')->name('moved.store');
		
	Route::any('moved/edit/{rec_id}', 'MovedController@edit')->name('moved.edit');	
	Route::get('moved/delete/{rec_id}', 'MovedController@delete');

/* routes for Office Controller */
	Route::get('office', 'OfficeController@index')->name('office.index');
	Route::get('office/index/{filter?}/{filtervalue?}', 'OfficeController@index')->name('office.index');	
	Route::get('office/view/{rec_id}', 'OfficeController@view')->name('office.view');	
	Route::get('office/add', 'OfficeController@add')->name('office.add');
	Route::post('office/add', 'OfficeController@store')->name('office.store');
		
	Route::any('office/edit/{rec_id}', 'OfficeController@edit')->name('office.edit');	
	Route::get('office/delete/{rec_id}', 'OfficeController@delete');

/* routes for Permissions Controller */
	Route::get('permissions', 'PermissionsController@index')->name('permissions.index');
	Route::get('permissions/index/{filter?}/{filtervalue?}', 'PermissionsController@index')->name('permissions.index');	
	Route::get('permissions/view/{rec_id}', 'PermissionsController@view')->name('permissions.view');	
	Route::get('permissions/add', 'PermissionsController@add')->name('permissions.add');
	Route::post('permissions/add', 'PermissionsController@store')->name('permissions.store');
		
	Route::any('permissions/edit/{rec_id}', 'PermissionsController@edit')->name('permissions.edit');	
	Route::get('permissions/delete/{rec_id}', 'PermissionsController@delete');

/* routes for Property Controller */
	Route::get('property', 'PropertyController@index')->name('property.index');
	Route::get('property/index/{filter?}/{filtervalue?}', 'PropertyController@index')->name('property.index');	
	Route::get('property/view/{rec_id}', 'PropertyController@view')->name('property.view');	
	Route::get('property/add', 'PropertyController@add')->name('property.add');
	Route::post('property/add', 'PropertyController@store')->name('property.store');
		
	Route::any('property/edit/{rec_id}', 'PropertyController@edit')->name('property.edit');	
	Route::get('property/delete/{rec_id}', 'PropertyController@delete');

/* routes for Roles Controller */
	Route::get('roles', 'RolesController@index')->name('roles.index');
	Route::get('roles/index/{filter?}/{filtervalue?}', 'RolesController@index')->name('roles.index');	
	Route::get('roles/view/{rec_id}', 'RolesController@view')->name('roles.view');
	Route::get('roles/masterdetail/{rec_id}', 'RolesController@masterDetail')->name('roles.masterdetail')->withoutMiddleware(['rbac']);	
	Route::get('roles/add', 'RolesController@add')->name('roles.add');
	Route::post('roles/add', 'RolesController@store')->name('roles.store');
		
	Route::any('roles/edit/{rec_id}', 'RolesController@edit')->name('roles.edit');	
	Route::get('roles/delete/{rec_id}', 'RolesController@delete');

/* routes for User Controller */
	Route::get('user', 'UserController@index')->name('user.index');
	Route::get('user/index/{filter?}/{filtervalue?}', 'UserController@index')->name('user.index');	
	Route::get('user/view/{rec_id}', 'UserController@view')->name('user.view');	
	Route::any('account/edit', 'AccountController@edit')->name('account.edit');	
	Route::get('account', 'AccountController@index');	
	Route::post('account/changepassword', 'AccountController@changepassword')->name('account.changepassword');	
	Route::get('user/add', 'UserController@add')->name('user.add');
	Route::post('user/add', 'UserController@store')->name('user.store');
		
	Route::any('user/edit/{rec_id}', 'UserController@edit')->name('user.edit');	
	Route::get('user/delete/{rec_id}', 'UserController@delete');
});


	
Route::get('componentsdata/office_option_list',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->office_option_list($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/asset_id_option_list',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->asset_id_option_list($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/name_option_list',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->name_option_list($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/office_from_option_list',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->office_from_option_list($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/role_id_option_list',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->role_id_option_list($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/user_username_value_exist',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->user_username_value_exist($request);
	}
);
	
Route::get('componentsdata/user_email_value_exist',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->user_email_value_exist($request);
	}
);
	
Route::get('componentsdata/getcount_assetregister',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->getcount_assetregister($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/getcount_issues',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->getcount_issues($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/getcount_moved',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->getcount_moved($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/getcount_desposed',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->getcount_desposed($request);
	}
)->middleware(['auth']);


Route::post('fileuploader/upload/{fieldname}', 'FileUploaderController@upload');
Route::post('fileuploader/s3upload/{fieldname}', 'FileUploaderController@s3upload');
Route::post('fileuploader/remove_temp_file', 'FileUploaderController@remove_temp_file');


/**
 * All static content routes
 */
Route::get('info/about',  function(){
		return view("pages.info.about");
	}
);
Route::get('info/faq',  function(){
		return view("pages.info.faq");
	}
);

Route::get('info/contact',  function(){
	return view("pages.info.contact");
}
);
Route::get('info/contactsent',  function(){
	return view("pages.info.contactsent");
}
);

Route::post('info/contact',  function(Request $request){
		$request->validate([
			'name' => 'required',
			'email' => 'required|email',
			'message' => 'required'
		]);

		$senderName = $request->name;
		$senderEmail = $request->email;
		$message = $request->message;

		$receiverEmail = config("mail.from.address");

		Mail::send(
			'pages.info.contactemail', [
				'name' => $senderName,
				'email' => $senderEmail,
				'comment' => $message
			],
			function ($mail) use ($senderEmail, $receiverEmail) {
				$mail->from($senderEmail);
				$mail->to($receiverEmail)
					->subject('Contact Form');
			}
		);
		return redirect("info/contactsent");
	}
);


Route::get('info/features',  function(){
		return view("pages.info.features");
	}
);
Route::get('info/privacypolicy',  function(){
		return view("pages.info.privacypolicy");
	}
);
Route::get('info/termsandconditions',  function(){
		return view("pages.info.termsandconditions");
	}
);

Route::get('info/changelocale/{locale}', function ($locale) {
	app()->setlocale($locale);
	session()->put('locale', $locale);
    return redirect()->back();
})->name('info.changelocale');