<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ServiceCategory extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'service_categories';
	
	protected $fillable = [
		'name',
		'country_list_type',
	];
	
	public function countries(){
		return $this->belongsToMany('App\Models\ServiceCountry', 'service_categories_countries', 'category_id', 'country_id');
	}
	
	public function operators(){
		return $this->belongsToMany('App\Models\ServiceOperator', 'service_categories_operators', 'category_id', 'operator_id');
	}
	
}