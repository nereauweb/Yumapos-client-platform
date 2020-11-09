<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceCountry extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'service_countries';
	
	protected $fillable = [
		'iso',
		'name',
	];
	
	public function operators(){ 
		return $this->hasMany('App\Models\ServiceOperator','country_id','id'); 
	}
	
}