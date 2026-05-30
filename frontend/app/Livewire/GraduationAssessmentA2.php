<?php

namespace App\Livewire;

use Livewire\Component;

class GraduationAssessmentA2 extends Component
{
    public $clientId;
    public $clientData = [];
    public $isEligible = null;
    public $eligibilityGaps = [];

    public function mount()
    {
        // Mock client data
        $this->clientData = [
            'name' => 'Alice Johnson',
            'client_id' => 'CL-6729-441',
            'current_loan_cycle' => 3,
            'repayment_rate' => 95,
            'savings_balance' => 4500,
            'business_duration_months' => 12
        ];
    }

    public function assessEligibility()
    {
        $gaps = [];

        if ($this->clientData['repayment_rate'] < 98) {
            $gaps[] = "Repayment rate is {$this->clientData['repayment_rate']}%. Required is 98%.";
        }

        if ($this->clientData['savings_balance'] < 5000) {
            $gaps[] = "Savings balance is {$this->clientData['savings_balance']}. Required is 5000.";
        }
        
        if ($this->clientData['business_duration_months'] < 24) {
             $gaps[] = "Business duration is {$this->clientData['business_duration_months']} months. Required is 24 months.";
        }

        $this->eligibilityGaps = $gaps;
        $this->isEligible = count($this->eligibilityGaps) === 0;
    }

    public function render()
    {
        return view('livewire.graduation-assessment-a2')->layout('layouts.app');
    }
}
