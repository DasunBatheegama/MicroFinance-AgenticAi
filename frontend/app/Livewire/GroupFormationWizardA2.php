<?php

namespace App\Livewire;

use Livewire\Component;

class GroupFormationWizardA2 extends Component
{
    public $search = '';
    public $clients = [];
    public $selectedMembers = [];
    public $groupName = '';
    public $hasOverdueWarning = false;

    // Mock Database for Clients
    private function getAvailableClients()
    {
        return [
            ['id' => 1, 'nic' => '199012345678', 'name' => 'John Doe', 'status' => 'Active', 'has_overdue' => false],
            ['id' => 2, 'nic' => '198512345678', 'name' => 'Jane Smith', 'status' => 'Active', 'has_overdue' => true],
            ['id' => 3, 'nic' => '199212345678', 'name' => 'Alice Johnson', 'status' => 'Active', 'has_overdue' => false],
            ['id' => 4, 'nic' => '198812345678', 'name' => 'Bob Brown', 'status' => 'Active', 'has_overdue' => false],
            ['id' => 5, 'nic' => '199512345678', 'name' => 'Charlie Davis', 'status' => 'Active', 'has_overdue' => true],
        ];
    }

    public function mount()
    {
        $this->clients = collect($this->getAvailableClients());
    }

    public function updatedSearch()
    {
        $allClients = collect($this->getAvailableClients());
        if (!empty($this->search)) {
            $this->clients = $allClients->filter(function ($client) {
                return stripos($client['name'], $this->search) !== false || stripos($client['nic'], $this->search) !== false;
            })->values();
        } else {
            $this->clients = $allClients;
        }
    }

    public function addMember($clientId)
    {
        if (count($this->selectedMembers) >= 3) {
            $this->addError('members', 'You can only select up to 3 members per group.');
            return;
        }

        $client = collect($this->getAvailableClients())->firstWhere('id', $clientId);

        if ($client && !collect($this->selectedMembers)->contains('id', $clientId)) {
            $this->selectedMembers[] = $client;
            $this->checkOverdueStatus();
        }
    }

    public function removeMember($clientId)
    {
        $this->selectedMembers = collect($this->selectedMembers)->reject(function ($member) use ($clientId) {
            return $member['id'] == $clientId;
        })->values()->toArray();

        $this->checkOverdueStatus();
        
        if (count($this->selectedMembers) < 3) {
            $this->resetErrorBag('members');
        }
    }

    private function checkOverdueStatus()
    {
        $this->hasOverdueWarning = collect($this->selectedMembers)->contains('has_overdue', true);
    }

    public function submitFormation()
    {
        $this->validate([
            'groupName' => 'required|min:3',
            'selectedMembers' => 'required|array|size:3',
        ], [
            'selectedMembers.size' => 'Exactly 3 members are required to form a group.',
        ]);

        if ($this->hasOverdueWarning) {
            $this->addError('overdue', 'Cannot form a group with members who have overdue loans.');
            return;
        }

        // Logic to save group

        session()->flash('message', 'Group "' . $this->groupName . '" formed successfully!');
        
        $this->reset(['groupName', 'selectedMembers', 'search', 'hasOverdueWarning']);
        $this->clients = collect($this->getAvailableClients());
    }

    public function render()
    {
        return view('livewire.group-formation-wizard-a2')->layout('layouts.app');
    }
}
