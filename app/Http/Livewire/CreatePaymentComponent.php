<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;


class CreatePaymentComponent extends Component
{
    public $userSelected;

    /**
     * render loads the component which mounts the payment view, located in livewire/create-payment-component.blade.php,
     * this component is called inside view: admin/payments/pay-user.blade.php
     * here are loaded the users + is a condition when a user from dropdown is selected to see if it is an agent or not,
     * based on the result it would show the agent group or not.
     */
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
