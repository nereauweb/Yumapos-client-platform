<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class UserPayment extends Component
{
    use WithPagination;

    public $from;
    public $to;
    public $state;
    public $positiveBalance;
    public $negativeBalance;
    public $totalBalance;

    protected $paginationTheme = 'bootstrap';

    private $payments;

    // mount function is used when first time the view is loaded
    public function mount()
    {
        $this->load();
    }

    // render function listens for changes and based on those changes loads the data
    public function render()
    {
        $this->load();
        return view('livewire.user-payment', ['payments' => $this->payments]);
    }

    // load function loads the data related to payments and implements within the query the needed filters
    public function load()
    {
        $this->payments = Payment::where('user_id',auth()->user()->id)->orWhere('target_id',auth()->user()->id)->when(($this->from !== null && !empty($this->from)), function ($query) {
            $query->where('date', '>=', $this->from);
        })->when(($this->to !== null && !empty($this->to)), function ($query) {
            $query->where('date', '<=', $this->to);
        })->when($this->state, function ($query) {
            $query->where('approved', '=', $this->state == '00' ? 0 : $this->state);
        })->orderBy('id','desc')->paginate(10);

        $this->totalBalance = $this->payments->where('type', '=', 2)->where('approved', '=', 1)->sum('amount') + auth()->user()->plafound;
        $this->negativeBalance = $this->payments->where('type', '=', 1)->where('approved', '=', 1)->sum('amount') + auth()->user()->plafound;
    }
}
