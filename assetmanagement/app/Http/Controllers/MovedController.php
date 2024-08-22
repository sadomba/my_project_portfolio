<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovedAddRequest;
use App\Http\Requests\MovedEditRequest;
use App\Models\Moved;
use Illuminate\Http\Request;
use Exception;
class MovedController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.moved.list";
		$query = Moved::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Moved::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "moved.move_id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Moved::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Moved::query();
		$record = $query->findOrFail($rec_id, Moved::viewFields());
		return $this->renderView("pages.moved.view", ["data" => $record]);
	}
	

	/**
     * Display form page
     * @return \Illuminate\View\View
     */
	function add(){
		return $this->renderView("pages.moved.add");
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function store(MovedAddRequest $request){
		$modeldata = $this->normalizeFormData($request->validated());
		
		//save Moved record
		$record = Moved::create($modeldata);
		$rec_id = $record->move_id;
		return $this->redirect("moved", "Record added successfully");
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(MovedEditRequest $request, $rec_id = null){
		$query = Moved::query();
		$record = $query->findOrFail($rec_id, Moved::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $this->normalizeFormData($request->validated());
			$record->update($modeldata);
			return $this->redirect("moved", "Record updated successfully");
		}
		return $this->renderView("pages.moved.edit", ["data" => $record, "rec_id" => $rec_id]);
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
		$query = Moved::query();
		$query->whereIn("move_id", $arr_id);
		//to raise audit trail delete event, use Eloquent 'get' before delete
		$query->get()->each(function ($record, $key) {
			$record->delete();
		});
		$redirectUrl = $request->redirect ?? url()->previous();
		return $this->redirect($redirectUrl, "Record deleted successfully");
	}
}
