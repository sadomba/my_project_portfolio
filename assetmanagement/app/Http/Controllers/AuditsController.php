<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Audits;
use Illuminate\Http\Request;
use Exception;
class AuditsController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.audits.list";
		$query = Audits::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Audits::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "audits.id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		$records = $query->paginate($limit, Audits::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Audits::query();
		$record = $query->findOrFail($rec_id, Audits::viewFields());
		return $this->renderView("pages.audits.view", ["data" => $record]);
	}
}
