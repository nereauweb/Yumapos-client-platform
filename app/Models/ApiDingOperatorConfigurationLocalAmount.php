<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiDingOperatorConfigurationLocalAmount extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_operators_configurations_local_amounts';
	
	protected $fillable = [
		'parent_id',
		'original_amount',
		'final_amount',
		'discount',
		'visible',
		];
}