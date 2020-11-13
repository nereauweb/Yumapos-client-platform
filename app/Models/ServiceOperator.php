<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceOperator extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'service_operators';
	
	protected $fillable = [
		'name',
		'country_id',
		'master',
		'ding_ProviderCode',
		'reloadly_operatorId',
	];
	
	public function main(){
		if ($this->master=="reloadly"){
			return $this->reloadly();
		}
		return $this->ding();
	}
	public function ding(){ 
		return $this->hasOne('App\Models\ApiDingOperator','ProviderCode','ding_ProviderCode'); 
	}
	public function reloadly(){ 
		return $this->hasOne('App\Models\ApiReloadlyOperator','operatorId','reloadly_operatorId'); 
	}
	
	public function country(){ 
		return $this->hasOne('App\Models\ServiceCountry','id','country_id'); 
	}
	
	public function type(){
		if ($this->master=="reloadly"){
			return $this->reloadly->denominationType;
		}
		return $this->ding->products_type();
	}
	
}