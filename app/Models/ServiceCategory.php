<?php

namespace App\Models;

use App\Models\ServiceOperator;

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
		'operator_list_type'
	];
	
	public function countries(){
		return $this->belongsToMany('App\Models\ServiceCountry', 'service_categories_countries', 'category_id', 'country_id');
	}
	
	public function operators(){
		return $this->belongsToMany('App\Models\ServiceOperator', 'service_categories_operators', 'category_id', 'operator_id');
	}
	
	public function allowed_operators(){
		if ($this->operator_list_type=="include"){
			return $this->operators();
		}
		return ServiceOperator::select('service_operators.*')->whereNotIn($this->operators()->pluck('id'));
	}
	
}