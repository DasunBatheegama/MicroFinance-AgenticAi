<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\LoanApplication;

class LoanApplicationFormA2 extends Component
{
    // General Loan Fields
    public $clientId;
    public $requestedAmount = 0;
    public $loanPurpose;
    public $termMonths = 12;
    public $interestRate = 2.5; // Monthly interest rate percentage

    // Cashflow Worksheet Fields
    public $monthlyIncome = 0;
    public $monthlyBusinessExpenses = 0;
    public $monthlyHouseholdExpenses = 0;
    public $otherDebtObligations = 0;

    // Derived Affordability Indicators
    public $netDisposableIncome = 0;
    public $proposedInstallment = 0;
    public $affordabilityRatio = 0;
    public $isAffordable = false;

    // Credit Memo Draft
    public $creditMemoDraft = '';

    public function mount()
    {
        $this->calculateAffordability();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, [
            'requestedAmount', 'termMonths', 'interestRate',
            'monthlyIncome', 'monthlyBusinessExpenses', 
            'monthlyHouseholdExpenses', 'otherDebtObligations'
        ])) {
            $this->calculateAffordability();
        }
    }

    public function calculateAffordability()
    {
        $this->netDisposableIncome = (float)$this->monthlyIncome 
            - (float)$this->monthlyBusinessExpenses 
            - (float)$this->monthlyHouseholdExpenses 
            - (float)$this->otherDebtObligations;

        if ($this->termMonths > 0) {
            // Simplified straight line calculation for quick estimation
            $principalInstallment = (float)$this->requestedAmount / (int)$this->termMonths;
            $interestInstallment = (float)$this->requestedAmount * ((float)$this->interestRate / 100);
            $this->proposedInstallment = $principalInstallment + $interestInstallment;
        } else {
            $this->proposedInstallment = 0;
        }

        if ($this->netDisposableIncome > 0) {
            $this->affordabilityRatio = ($this->proposedInstallment / $this->netDisposableIncome) * 100;
        } else {
            $this->affordabilityRatio = 0;
        }

        // Commonly, affordability ratio should be <= 40%
        $this->isAffordable = ($this->netDisposableIncome > 0 && $this->affordabilityRatio <= 40);

        $this->generateCreditMemoDraft();
    }

    public function generateCreditMemoDraft()
    {
        $affordableText = $this->isAffordable ? "within acceptable limits" : "exceeding standard limits";
        
        $this->creditMemoDraft = "Client is requesting a loan of " . number_format((float)$this->requestedAmount, 2) . 
            " for a term of {$this->termMonths} months for the purpose of '{$this->loanPurpose}'.\n\n" .
            "Financial Summary:\n" .
            "- Net Disposable Income: " . number_format($this->netDisposableIncome, 2) . "\n" .
            "- Proposed Monthly Installment: " . number_format($this->proposedInstallment, 2) . "\n" .
            "- Affordability Ratio: " . number_format($this->affordabilityRatio, 2) . "%\n\n" .
            "Assessment:\n" .
            "The proposed installment represents " . number_format($this->affordabilityRatio, 2) . "% of the client's net disposable income, which is {$affordableText}.";
    }

    public function submitApplication()
    {
        $this->validate([
            'requestedAmount' => 'required|numeric|min:100',
            'termMonths' => 'required|integer|min:1',
            'loanPurpose' => 'required|string',
            'monthlyIncome' => 'required|numeric|min:0',
        ]);

        LoanApplication::create([
            'client_id' => $this->clientId ?? 1, // fallback to 1 for demo
            'amount' => $this->requestedAmount,
            'purpose' => $this->loanPurpose,
            'term_months' => $this->termMonths,
            'status' => 'Pending',
            'cashflow_data' => json_encode([
                'monthly_income' => $this->monthlyIncome,
                'business_expenses' => $this->monthlyBusinessExpenses,
                'household_expenses' => $this->monthlyHouseholdExpenses,
                'other_debt' => $this->otherDebtObligations,
                'net_disposable_income' => $this->netDisposableIncome,
                'proposed_installment' => $this->proposedInstallment,
                'affordability_ratio' => $this->affordabilityRatio,
            ]),
            'credit_memo' => $this->creditMemoDraft,
        ]);

        session()->flash('message', 'Loan Application Submitted Successfully.');
        $this->reset(['requestedAmount', 'loanPurpose', 'monthlyIncome', 'monthlyBusinessExpenses', 'monthlyHouseholdExpenses', 'otherDebtObligations']);
        $this->calculateAffordability();
    }

    public function render()
    {
        return view('livewire.loan-application-form-a2');
    }
}
