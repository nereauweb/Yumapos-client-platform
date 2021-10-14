<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiMbsProduct extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_mbs_products_list';
	
	protected $fillable = [
		'Prodotto',
		'Operatore',
		'Tipo',
		'SottoTipo',
		'Descrizione',
		'PrezzoUtente',
		'image',
		'Costo'
		];
	
	public function configurations(){ 
		return $this->hasMany('App\Models\ApiMbsConfiguration','product_id','id'); 
	}
	
	public function configuration($group_id){
		return $this->configurations->where('group_id', $group_id)->first();
	}
	
	public function user_discount(){
		$discount = 0;
		try{
			$discount = $this->configuration(\Auth::user()->group_id)->percent;
		} catch (\Exception $ex) {
			return 0;
		}
		return $discount;
	}
	
	public function user_price(){
		$discount = $this->user_discount();
		return $this->PrezzoUtente - ($this->PrezzoUtente * ($discount/100));
	}
	
}