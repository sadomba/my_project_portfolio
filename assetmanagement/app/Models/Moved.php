<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
class Moved extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'moved';
	

	/**
     * The table primary key field
     *
     * @var string
     */
	protected $primaryKey = 'move_id';
	

	/**
     * Table fillable fields
     *
     * @var array
     */
	protected $fillable = [
		'asset_id','reason','office_from','office_to'
	];
	public $timestamps = false;
	

	/**
     * Set search query for the model
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param string $text
     */
	public static function search($query, $text){
		//search table record 
		$search_condition = '(
				asset_id LIKE ?  OR 
				reason LIKE ?  OR 
				office_from LIKE ?  OR 
				office_to LIKE ?  OR 
				move_id LIKE ? 
		)';
		$search_params = [
			"%$text%","%$text%","%$text%","%$text%","%$text%"
		];
		//setting search conditions
		$query->whereRaw($search_condition, $search_params);
	}
	

	/**
     * return list page fields of the model.
     * 
     * @return array
     */
	public static function listFields(){
		return [ 
			"asset_id",
			"reason",
			"office_from",
			"office_to",
			"move_id" 
		];
	}
	

	/**
     * return exportList page fields of the model.
     * 
     * @return array
     */
	public static function exportListFields(){
		return [ 
			"asset_id",
			"reason",
			"office_from",
			"office_to",
			"move_id" 
		];
	}
	

	/**
     * return view page fields of the model.
     * 
     * @return array
     */
	public static function viewFields(){
		return [ 
			"asset_id",
			"reason",
			"office_from",
			"office_to",
			"move_id" 
		];
	}
	

	/**
     * return exportView page fields of the model.
     * 
     * @return array
     */
	public static function exportViewFields(){
		return [ 
			"asset_id",
			"reason",
			"office_from",
			"office_to",
			"move_id" 
		];
	}
	

	/**
     * return edit page fields of the model.
     * 
     * @return array
     */
	public static function editFields(){
		return [ 
			"asset_id",
			"reason",
			"office_from",
			"office_to",
			"move_id" 
		];
	}
	

	/**
     * Audit log events
     * 
     * @var array
     */
	protected $auditEvents = [
		'created', 'updated', 'deleted'
	];
}
