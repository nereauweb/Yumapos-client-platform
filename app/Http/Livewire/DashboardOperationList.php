<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DashboardOperationList extends Component
{
    public $filterSelected = 'day';

    public function render()
    {
        $services = auth()->user()->adminAccessServices($this->filterSelected);
        return view('livewire.dashboard-operation-list', compact('services'));
    }
}
