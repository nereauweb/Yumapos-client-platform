<?php

namespace App\Http\Livewire;

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

    public function mount()
    {
        $this->load();
    }

    public function render()
    {
        $this->load();
        return view('livewire.user-payment', ['payments' => $this->payments]);
    }

    public function load()
    {
        $this->payments = auth()->user()->payments()->when(($this->from !== null && !empty($this->from)), function ($query) {
            $query->where('date', '>=', $this->from);
        })->when(($this->to !== null && !empty($this->to)), function ($query) {
            $query->where('date', '<=', $this->to);
        })->when($this->state, function ($query) {
            $query->where('approved', '=', $this->state == '00' ? 0 : $this->state);
        })->paginate(10);

        $this->totalBalance = $this->payments->where('type', '=', 2)->where('approved', '=', 1)->sum('amount') + auth()->user()->plafound;
        $this->negativeBalance = $this->payments->where('type', '=', 1)->where('approved', '=', 1)->sum('amount') + auth()->user()->plafound;
    }
}