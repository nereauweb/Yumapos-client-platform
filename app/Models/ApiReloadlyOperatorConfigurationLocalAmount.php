<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiReloadlyOperatorConfigurationLocalAmount extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_reloadly_operators_configurations_local_amounts';
	
	protected $fillable = [
		'parent_id',
		'original_amount',
		'final_amount',
		'discount',
		'visible',
		];
}