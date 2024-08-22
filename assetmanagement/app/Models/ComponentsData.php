<?php 
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * Components data Model
 * Use for getting values from the database for page components
 * Support raw query builder
 * @category Model
 */
class ComponentsData{
	

	/**
     * office_option_list Model Action
     * @return array
     */
	function office_option_list(){
		$sqltext = "SELECT  DISTINCT office_id AS value,office_name AS label FROM office ORDER BY office_name ASC";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * asset_id_option_list Model Action
     * @return array
     */
	function asset_id_option_list(){
		$sqltext = "SELECT  DISTINCT asset_id AS value,asset_id AS label FROM asset_register ORDER BY asset_id ASC";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * name_option_list Model Action
     * @return array
     */
	function name_option_list(){
		$sqltext = "SELECT  DISTINCT name AS value,name AS label FROM asset_register ORDER BY name ASC";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * office_from_option_list Model Action
     * @return array
     */
	function office_from_option_list(){
		$sqltext = "SELECT  DISTINCT office_name AS value,office_name AS label FROM office ORDER BY office_name ASC";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * role_id_option_list Model Action
     * @return array
     */
	function role_id_option_list(){
		$sqltext = "SELECT role_id as value, role_name as label FROM roles";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * Check if value already exist in User table
	 * @param string $value
     * @return bool
     */
	function user_username_value_exist(Request $request){
		$value = trim($request->value);
		$exist = DB::table('user')->where('username', $value)->value('username');   
		if($exist){
			return true;
		}
		return false;
	}
	

	/**
     * Check if value already exist in User table
	 * @param string $value
     * @return bool
     */
	function user_email_value_exist(Request $request){
		$value = trim($request->value);
		$exist = DB::table('user')->where('email', $value)->value('email');   
		if($exist){
			return true;
		}
		return false;
	}
	

	/**
     * getcount_assetregister Model Action
     * @return int
     */
	function getcount_assetregister(){
		$sqltext = "SELECT COUNT(*) AS num FROM asset_register";
		$query_params = [];
		$val = DB::selectOne($sqltext, $query_params);
		return $val->num;
	}
	

	/**
     * getcount_issues Model Action
     * @return int
     */
	function getcount_issues(){
		$sqltext = "SELECT COUNT(*) AS num FROM issues";
		$query_params = [];
		$val = DB::selectOne($sqltext, $query_params);
		return $val->num;
	}
	

	/**
     * getcount_moved Model Action
     * @return int
     */
	function getcount_moved(){
		$sqltext = "SELECT COUNT(*) AS num FROM moved";
		$query_params = [];
		$val = DB::selectOne($sqltext, $query_params);
		return $val->num;
	}
	

	/**
     * getcount_desposed Model Action
     * @return int
     */
	function getcount_desposed(){
		$sqltext = "SELECT COUNT(*) AS num FROM desposed";
		$query_params = [];
		$val = DB::selectOne($sqltext, $query_params);
		return $val->num;
	}
}
