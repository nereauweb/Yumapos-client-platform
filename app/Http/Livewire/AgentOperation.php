<?php

namespace App\Http\Livewire;

use App\Models\AgentOperation as ModelsAgentOperation;
use App\User;
use Livewire\Component;
use Livewire\WithPagination;

class AgentOperation extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $from;
    public $to;

    public $sortField;
    public $sortAsc = true;

    public $agentSelected;

    public $totalOperations;
    public $sumOfOperations;
    public $sumOfCom;

    public $user_id;

    public function render()
    {
        $users = User::pluck('name','id');
        $agents = User::role('sales')->pluck('name', 'id');
		$useridsCollection = User::role('sales')->pluck('id');
        $user_name = "All agents";

		$user_id = 0;
		if (($this->user_id && !is_null($this->user_id)) && $this->user_id !=0){
			$user = User::findOrFail($this->user_id);
			if ($user->role('sales')) {
				$user_name = $user->name;
				$user_id = $user->id;
			}
        }

        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';

		$operations = ModelsAgentOperation::where('created_at','>=', $date_begin)->where('created_at','<=',$date_end)->when($this->agentSelected, function ($query) {
		    $query->where('user_id', $this->agentSelected);
        })->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->orderBy('id', 'desc');

        if($user_id!=0){
            $operations->where('user_id',$user_id);
        }

        $this->totalOperations = $operations->count();
        $this->sumOfOperations = $operations->sum('original_amount');
        $this->sumOfCom = $operations->sum('commission');

        $operations = $operations->paginate(10);

        return view('livewire.agent-operation', compact('operations','date_begin','date_end','users','user_name','user_id', 'agents'));
    }

    public function commit() {}

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
}
