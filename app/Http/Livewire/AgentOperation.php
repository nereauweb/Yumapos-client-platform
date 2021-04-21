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

    /* Function to load data on each action being taken in the interface */
    public function render()
    {
        /*
         * Get list of operations limited to the role of agent
         * the query that returns results is $operations variable
         * view that gets returned is located in livewire/agent-operation.blade.php
         * */
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
		
		$report_operations = $operations;
		$operations = $operations->paginate(10);
		
		$report_operations->whereHas('pointOperation', function($q) {
			$q->whereNull('report_status')->orWhere('report_status','!=','refunded'); 
		});

        $this->totalOperations = $report_operations->count();
        $this->sumOfOperations = $report_operations->sum('original_amount');
        $this->sumOfCom = $report_operations->sum('commission');

        return view('livewire.agent-operation', compact('operations','date_begin','date_end','users','user_name','user_id', 'agents'));
    }

    /*
     * commit function serves solely to trigger the button in interface,
     * meaning we don't trigger anything unless button is clicked,
     * when button gets clicked this function gets called,
     * which triggers the load of render function with the applied filters
     * */
    public function commit() {}

    /*
     * sortBy function serves for the purpose of applying the filters to the query inside render function,
     * here we update the variables which we use as filters in our custom query inside render function
     * */
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
