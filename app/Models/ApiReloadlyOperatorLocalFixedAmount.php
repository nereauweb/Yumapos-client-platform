<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiReloadlyOperatorLocalFixedAmount extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_reloadly_operators_localFixedAmounts';
	
	protected $fillable = [
		'parent_id',
		'amount',
		];
	
	public function configuration(){		
		return $this->hasOne('App\Models\ApiReloadlyOperatorConfiguration','id','parent_id'); 
	}
}