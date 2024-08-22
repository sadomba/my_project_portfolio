<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeAddRequest;
use App\Http\Requests\OfficeEditRequest;
use App\Models\Office;
use Illuminate\Http\Request;
use Exception;
class OfficeController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.office.list";
		$query = Office::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Office::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "office.office_id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Office::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Office::query();
		$record = $query->findOrFail($rec_id, Office::viewFields());
		return $this->renderView("pages.office.view", ["data" => $record]);
	}
	

	/**
     * Display form page
     * @return \Illuminate\View\View
     */
	function add(){
		return $this->renderView("pages.office.add");
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function store(OfficeAddRequest $request){
		$modeldata = $this->normalizeFormData($request->validated());
		
		//save Office record
		$record = Office::create($modeldata);
		$rec_id = $record->office_id;
		return $this->redirect("office", "Record added successfully");
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(OfficeEditRequest $request, $rec_id = null){
		$query = Office::query();
		$record = $query->findOrFail($rec_id, Office::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $this->normalizeFormData($request->validated());
			$record->update($modeldata);
			return $this->redirect("office", "Record updated successfully");
		}
		return $this->renderView("pages.office.edit", ["data" => $record, "rec_id" => $rec_id]);
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
		$query = Office::query();
		$query->whereIn("office_id", $arr_id);
		//to raise audit trail delete event, use Eloquent 'get' before delete
		$query->get()->each(function ($record, $key) {
			$record->delete();
		});
		$redirectUrl = $request->redirect ?? url()->previous();
		return $this->redirect($redirectUrl, "Record deleted successfully");
	}
}
