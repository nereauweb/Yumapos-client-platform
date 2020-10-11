<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentFile extends Model
{
    use SoftDeletes;

    protected $guarded = []; 

    protected $table = 'payments_file';

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
