<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'providers';
	
	protected $fillable = [
		'company_name',
		'legal_seat',
		'legal_seat_address',
		'legal_seat_zip',
		'legal_seat_city',
		'legal_seat_region',
		'legal_seat_country',
		'operative_seat',
		'operative_seat_address',
		'operative_seat_zip',
		'operative_seat_city',
		'operative_seat_region',
		'operative_seat_country',
		'vat',
		'tax_unique_code',
		'pec',
		'email',
		'phone',
		'website',
		'support_email',
		];
		
	public referent(){
		return $this->hasMany('App\Models\ProviderReferent','provider_id','id');
	}

}