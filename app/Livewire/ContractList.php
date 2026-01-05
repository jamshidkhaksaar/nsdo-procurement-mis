<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Contract;
use App\Models\Project;

class ContractList extends Component
{
    use WithPagination;

    public $search = '';
    public $project_id = '';

    public $selectedContract = null;
    public $showModal = false;

    #[On('echo:contracts,ContractCreated')]
    #[On('echo:contracts,ContractDeleted')]
    public function refreshList()
    {
        // Re-renders automatically
    }

    public function viewContract($id)
    {
        $this->selectedContract = Contract::with(['project', 'amendments'])->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedContract = null;
    }

    public function render()
    {
        $query = Contract::with('project');

        if ($this->project_id) {
            $query->where('project_id', $this->project_id);
        }

        if ($this->search) {
            $search = $this->search;
            $query->where(function($q) use ($search) {
                $q->where('vendor_name', 'like', "%{$search}%")
                  ->orWhere('contract_reference', 'like', "%{$search}%");
            });
        }

        return view('livewire.contract-list', [
            'contracts' => $query->latest()->paginate(10),
            'projects' => Project::all(),
        ]);
    }
}