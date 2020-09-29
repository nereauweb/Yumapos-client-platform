<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCompanyData extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_company_data';
	
	protected $fillable = [
		'user_id',
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
		'vat_percent',
		'witholding_tax_percent',
		'pec',
		'email',
		'phone',
		'mobile',
		'referent_name',
		'referent_surname',
		'referent_mobile',
		'shop_sign',
		];

}