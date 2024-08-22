<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\IssuesAddRequest;
use App\Http\Requests\IssuesEditRequest;
use App\Models\Issues;
use Illuminate\Http\Request;
use Exception;
class IssuesController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.issues.list";
		$query = Issues::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Issues::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "issues.issue_id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Issues::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Issues::query();
		$record = $query->findOrFail($rec_id, Issues::viewFields());
		return $this->renderView("pages.issues.view", ["data" => $record]);
	}
	

	/**
     * Display form page
     * @return \Illuminate\View\View
     */
	function add(){
		return $this->renderView("pages.issues.add");
	}
	

	/**
     * Save form record to the table
     * @return \Illuminate\Http\Response
     */
	function store(IssuesAddRequest $request){
		$modeldata = $this->normalizeFormData($request->validated());
		
		//save Issues record
		$record = Issues::create($modeldata);
		$rec_id = $record->issue_id;
		return $this->redirect("issues", "Record added successfully");
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(IssuesEditRequest $request, $rec_id = null){
		$query = Issues::query();
		$record = $query->findOrFail($rec_id, Issues::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $this->normalizeFormData($request->validated());
			$record->update($modeldata);
			return $this->redirect("issues", "Record updated successfully");
		}
		return $this->renderView("pages.issues.edit", ["data" => $record, "rec_id" => $rec_id]);
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
		$query = Issues::query();
		$query->whereIn("issue_id", $arr_id);
		//to raise audit trail delete event, use Eloquent 'get' before delete
		$query->get()->each(function ($record, $key) {
			$record->delete();
		});
		$redirectUrl = $request->redirect ?? url()->previous();
		return $this->redirect($redirectUrl, "Record deleted successfully");
	}
}
