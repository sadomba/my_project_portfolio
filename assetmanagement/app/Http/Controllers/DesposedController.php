<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\DesposedAddRequest;
use App\Http\Requests\DesposedEditRequest;
use App\Models\Desposed;
use Illuminate\Http\Request;
use Exception;
class DesposedController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.desposed.list";
		$query = Desposed::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Desposed::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "desposed.des_id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Desposed::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Desposed::query();
		$record = $query->findOrFail($rec_id, Desposed::viewFields());
		return $this->renderView("pages.desposed.view", ["data" => $record]);
	}
	

	/**
     * Display form page
     * @return \Illuminate\View\View
     */
	function add(){
		return $this->renderView("pages.desposed.add");
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function store(DesposedAddRequest $request){
		$modeldata = $this->normalizeFormData($request->validated());
		
		//save Desposed record
		$record = Desposed::create($modeldata);
		$rec_id = $record->des_id;
		return $this->redirect("desposed", "Record added successfully");
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(DesposedEditRequest $request, $rec_id = null){
		$query = Desposed::query();
		$record = $query->findOrFail($rec_id, Desposed::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $this->normalizeFormData($request->validated());
			$record->update($modeldata);
			return $this->redirect("desposed", "Record updated successfully");
		}
		return $this->renderView("pages.desposed.edit", ["data" => $record, "rec_id" => $rec_id]);
	}
	

	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
	 * @param  \Illuminate\Http\Request
	 * @param string $rec_id //can be separated by comma 
     * @return \Illuminate\Http\Response
     */
	function delete(Request $request, $rec_id = null){
		$arr_id = explode(",", $rec_id);
		$query = Desposed::query();
		$query->whereIn("des_id", $arr_id);
		//to raise audit trail delete event, use Eloquent 'get' before delete
		$query->get()->each(function ($record, $key) {
			$record->delete();
		});
		$redirectUrl = $request->redirect ?? url()->previous();
		return $this->redirect($redirectUrl, "Record deleted successfully");
	}
}
