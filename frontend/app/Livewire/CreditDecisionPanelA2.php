<?php

namespace App\Livewire;

use Livewire\Component;

class CreditDecisionPanelA2 extends Component
{
    public $screeningResult = [];
    public $decision = null;
    public $rationale = '';
    public $maker_name = '';
    public $checker_name = '';
    public $checker_approved = false;

    protected $rules = [
        'decision' => 'required|string',
        'rationale' => 'nullable|string|max:2000',
    ];

    public function mount($screeningResult = [])
    {
        $this->screeningResult = $screeningResult;
    }

    public function saveDecision()
    {
        $this->validate();

        // UI-only: flash a message. Persisting should be handled by backend logic.
        session()->flash('message', 'Decision saved (UI-only).');
    }

    public function render()
    {
        return view('livewire.credit-decision-panel-a2');
    }
}
