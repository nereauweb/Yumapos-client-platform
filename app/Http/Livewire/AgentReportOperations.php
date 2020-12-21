<?php

namespace App\Http\Livewire;

use App\Models\AgentOperation as ModelsAgentOperation;
use App\User;
use Livewire\Component;
use Livewire\WithPagination;

class AgentReportOperations extends Component
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

    /*
     * render function loads the view,
     * passes the query fetched from database to the view,
     * specific for AgentReportOperations livewire component is that it does
     * query from model AgentOperation the operations made by signed in agent
     * */
    public function render()
    {
        $date_begin = ($this->from && !is_null($this->from)) ? $this->from . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
        $date_end = ($this->to && !is_null($this->to)) ? $this->to . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';

        $operations = ModelsAgentOperation::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end)->where('user_id', auth()->id())->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->orderBy('id', 'desc');

        $this->totalOperations = $operations->count();
        $this->sumOfOperations = $operations->sum('original_amount');
        $this->sumOfCom = $operations->sum('commission');

        $operations = $operations->paginate(10);

        return view('livewire.agent-report-operations', compact('operations','date_begin','date_end'));
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
