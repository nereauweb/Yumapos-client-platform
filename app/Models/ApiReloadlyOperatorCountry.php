<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiReloadlyOperatorCountry extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_reloadly_operators_countries';
	
	protected $fillable = [
		'parent_id',
		'isoName',
		'name',
		];
    
    public function apiReloadlyOperators() 
    {
        return $this->hasMany(ApiReloadlyOperator::class);
    }
}