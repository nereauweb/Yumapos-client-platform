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
		'slug',
		'description',
		'discount',
		];
	
	public function members() {
		return $this->hasMany('App\User','group_id','id');
    }
	
}