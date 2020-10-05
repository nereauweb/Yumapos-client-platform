<?php

namespace App\Http\Livewire;

use App\Models\Payment as ModelsPayment;
use Livewire\Component;
use Livewire\WithPagination;

class Payment extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortField;
    public $sortAsc = true;


    public $filterByModel;

    public function render()
    {
        $payments = ModelsPayment::when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        });

        if (($this->filterByModel && !is_null($this->filterByModel) && is_null($this->sortField)) && $this->filterByModel == 'users.name') {  
            $payments = ModelsPayment::join('users as u', 'u.id', '=', 'payments.user_id')->orderBy('u.name', $this->sortAsc ? 'asc' : 'desc')->select('payments.*');
        }

        $payments = $payments->paginate(10);

        return view('livewire.payment', compact('payments'));
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function filterBy($tableColumn) {
        $this->sortField = null;
        switch ($tableColumn) {
            case 'users.name':
                $this->filterByModel = 'users.name';
                $this->sortAsc = !$this->sortAsc;
                break;
            default:
                # code...
                break;
        }

        // $this->customSort = $tableColumn
    }
}
