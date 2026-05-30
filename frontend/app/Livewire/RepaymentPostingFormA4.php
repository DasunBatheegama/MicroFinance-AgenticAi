<?php

namespace App\Livewire;

use Livewire\Component;

class RepaymentPostingFormA4 extends Component
{
    public $client_name = 'Jane Doe';
    public $loan_account_id = 'L001-9876';
    public $due_amount = 5000.00;
    public $amount_paid = '';
    public $payment_method = 'Cash';
    public $remarks = '';

    public $receipt_generated = false;
    public $receipt_details = [];

    protected $rules = [
        'amount_paid' => 'required|numeric|min:1',
        'payment_method' => 'required|string',
    ];

    public function processPayment()
    {
        $this->validate();

        $status = 'Full Payment';
        if ($this->amount_paid < $this->due_amount) {
            $status = 'Partial Payment';
        } elseif ($this->amount_paid > $this->due_amount) {
            $status = 'Over Payment';
        }

        $this->receipt_details = [
            'receipt_no' => 'REC-' . strtoupper(uniqid()),
            'client_name' => $this->client_name,
            'loan_account_id' => $this->loan_account_id,
            'amount_paid' => number_format($this->amount_paid, 2),
            'due_amount' => number_format($this->due_amount, 2),
            'balance' => number_format($this->due_amount - $this->amount_paid, 2),
            'status' => $status,
            'payment_method' => $this->payment_method,
            'date' => date('Y-m-d H:i:s'),
        ];

        $this->receipt_generated = true;
        session()->flash('message', 'Payment processed successfully.');
    }

    public function resetForm()
    {
        $this->reset(['amount_paid', 'payment_method', 'remarks', 'receipt_generated', 'receipt_details']);
    }

    public function render()
    {
        return view('livewire.repayment-posting-form-a4');
    }
}
