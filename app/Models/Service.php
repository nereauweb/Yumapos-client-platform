<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'services';
	
	protected $fillable = [
		'name',
		'category_id',
		'description',
	];
	
}