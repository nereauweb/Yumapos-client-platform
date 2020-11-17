<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersGroupConfiguration extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_groups_configurations';
	
	protected $fillable = [
		'group_id',
		'category_id',
		'target_group_id',
		'type',
		'amount',
		];
	
	public function group() {
		return $this->hasOne('App\UsersGroup','id','group_id');
    }
	
	public function target() {
		return $this->hasOne('App\UsersGroup','id','target_group_id');
    }
	
}