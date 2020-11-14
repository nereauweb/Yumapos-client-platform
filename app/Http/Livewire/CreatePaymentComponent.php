<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;


class CreatePaymentComponent extends Component
{
    public $userSelected;

    public function render()
    {
        $users = User::where('id', '!=', auth()->id())->orderBy('name')->get();

        if (!is_null($this->userSelected)) {
            $isAgent = \App\User::find($this->userSelected)->hasRole('sales');
        } else {
            $isAgent = false;
        }
        return view('livewire.create-payment-component', ['users' => $users, 'isAgent' => $isAgent]);
    }

}
