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
	];
	
}