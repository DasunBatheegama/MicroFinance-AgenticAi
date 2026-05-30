<?php

namespace App\Livewire;

use Livewire\Component;

class DisbursementChecklistA4 extends Component
{
    public $client_name = 'Jane Doe';
    public $loan_amount = 50000;
    
    public $conditions = [
        'contracts_signed' => false,
        'collateral_verified' => false,
        'insurance_active' => false,
        'bank_details_confirmed' => false,
    ];

    public $maker_confirmed = false;
    public $checker_confirmed = false;
    
    public $checker_username = '';
    public $checker_password = '';

    protected $rules = [
        'conditions.contracts_signed' => 'accepted',
        'conditions.collateral_verified' => 'accepted',
        'conditions.insurance_active' => 'accepted',
        'conditions.bank_details_confirmed' => 'accepted',
        'maker_confirmed' => 'accepted',
    ];

    public function authorizeDisbursement()
    {
        $this->validate();

        // Simulate dual-auth logic (e.g., in a real app, query the users table for the checker's credentials)
        if ($this->checker_username === 'admin' && $this->checker_password === 'password') {
            $this->checker_confirmed = true;
            session()->flash('message', 'Disbursement authorized successfully. Funds are ready for transfer.');
        } else {
            $this->checker_confirmed = false;
            session()->flash('error', 'Invalid Checker credentials. Authorization failed.');
        }
    }

    public function render()
    {
        return view('livewire.disbursement-checklist-a4');
    }
}
