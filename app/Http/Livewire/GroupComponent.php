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
        } else {
            $groups = null;
        }
        $defaultGroup = UsersGroup::where('type', '=', 1)->get();
        return view('livewire.group-component', compact('groups', 'defaultGroup'));
    }
}
