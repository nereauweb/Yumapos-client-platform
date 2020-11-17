<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class UsersGroup extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_groups';
	
	protected $fillable = [
		'type',
		'name',
		'description',
		'discount',
		];
		
	private $configurations = [];
	
	public function members() {
		return $this->hasMany('App\User','group_id','id');
    }
	
	public function configurations() {
		return $this->hasMany('App\Models\UsersGroupConfiguration','group_id','id');
    }
	
	public function configuration($target_group_id,$category_id) {
		if (!isset($configurations[$target_group_id][$category_id])){
			$configurations[$target_group_id][$category_id] = $this->configurations()
																->where('category_id',$category_id)
																->where('target_group_id',$target_group_id)
																->first();
		}
		return $configurations[$target_group_id][$category_id];
    }
	
}