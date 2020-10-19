<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderReferent extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'providers_referents';
	
	protected $fillable = [
		'provider_id',
		'name',
		'surname',
		'pec',
		'email',
		'phone',
		'mobile',
		'skype',
		];
	
	public function provider(){
		return $this->hasOne('App\Models\Provider','id','provider_id');
	}
	
}