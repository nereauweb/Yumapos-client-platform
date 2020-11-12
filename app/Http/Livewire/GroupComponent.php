<?php

namespace App\Http\Livewire;

use App\Models\UsersGroup;
use Livewire\Component;

class GroupComponent extends Component
{
    public $roles;
    public $roleSelected;

    public function render()
    {
        if ($this->roleSelected == 4) {
            $groups = UsersGroup::where('type', '=', 2)->get();
        } else if ($this->roleSelected == 2) {
            $groups = UsersGroup::where('type', '=', 1)->get();
        } else {
            $groups = [];
        }
        return view('livewire.group-component', compact('groups'));
    }
}
