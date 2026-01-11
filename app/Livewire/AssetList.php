<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Asset;
use App\Models\Project;

class AssetList extends Component
{
    use WithPagination;

    public $search = '';
    public $project_id = '';
    public $condition = '';
    public $perPage = 50;

    public $selectedAsset = null;
    public $showModal = false;

    #[On('echo:assets,AssetCreated')]
    public function refreshList()
    {
        // Re-renders automatically
    }

    public function viewAsset($id)
    {
        $this->selectedAsset = Asset::with(['project', 'assetType', 'province', 'department', 'staff', 'creator', 'editor'])->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedAsset = null;
    }

    public function render()
    {
        $query = Asset::with(['project', 'creator', 'editor', 'assetType'])->withCount('documents');

        if ($this->project_id) {
            $query->where('project_id', $this->project_id);
        }

        if ($this->condition) {
            $query->where('condition', $this->condition);
        }

        if ($this->search) {
            $search = $this->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_tag', 'like', "%{$search}%");
            });
        }

        return view('livewire.asset-list', [
            'assets' => $query->latest()->paginate($this->perPage),
            'projects' => Project::all(),
        ]);
    }
}