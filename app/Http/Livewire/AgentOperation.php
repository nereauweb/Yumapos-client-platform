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

    public $date_begin;
    public $date_end;

    public $totalOperations;

    public $user_id;

    public function render()
    {
        $users = User::pluck('name','id');
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

        $date_begin = ($this->date_begin && !is_null($this->date_begin)) ? $this->date_begin . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
        
        $date_end = ($this->date_end && !is_null($this->date_end)) ? $this->date_end . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
        
		$operations = ModelsAgentOperation::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end);
        
        if($user_id!=0){
        
            $operations->where('user_id',$user_id);
        
        }

        $totalOperations = $operations->count();
        
        $operations = $operations->paginate(10);
        
        return view('livewire.agent-operation', compact('operations','date_begin','date_end','users','user_name','user_id'));
    }

    public function commit() {}
}
