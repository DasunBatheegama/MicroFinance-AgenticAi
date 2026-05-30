<?php

namespace App\Livewire;

use Livewire\Component;

class ArrearsDashboardA3 extends Component
{
    public $searchQuery = '';
    public $filterBucket = ''; 
    
    // PTP (Promise To Pay) Modal
    public $showPtpModal = false;
    public $selectedAccountId = null;
    public $ptpDate = '';
    public $ptpAmount = '';
    public $ptpNote = '';

    // Dummy data for aging buckets and arrears
    public $arrearsAccounts = [];

    public function mount()
    {
        $this->arrearsAccounts = [
            ['id' => 'ACC-001', 'client_name' => 'John Doe', 'days_in_arrears' => 15, 'bucket' => '1-30 Days', 'amount_due' => 50.00, 'status' => 'Pending Action', 'ptp_date' => null],
            ['id' => 'ACC-002', 'client_name' => 'Jane Smith', 'days_in_arrears' => 45, 'bucket' => '31-60 Days', 'amount_due' => 120.00, 'status' => 'Follow Up', 'ptp_date' => '2026-06-05'],
            ['id' => 'ACC-003', 'client_name' => 'Michael Johnson', 'days_in_arrears' => 75, 'bucket' => '61-90 Days', 'amount_due' => 200.00, 'status' => 'Escalated', 'ptp_date' => null],
            ['id' => 'ACC-004', 'client_name' => 'Sara Lee', 'days_in_arrears' => 110, 'bucket' => '90+ Days', 'amount_due' => 450.00, 'status' => 'Legal Action', 'ptp_date' => null],
            ['id' => 'ACC-005', 'client_name' => 'Alex Turner', 'days_in_arrears' => 25, 'bucket' => '1-30 Days', 'amount_due' => 75.00, 'status' => 'Pending Action', 'ptp_date' => null],
        ];
    }

    public function getFilteredAccountsProperty()
    {
        $accounts = collect($this->arrearsAccounts);

        if (!empty($this->searchQuery)) {
            $accounts = $accounts->filter(function ($acc) {
                return stripos($acc['client_name'], $this->searchQuery) !== false || 
                       stripos($acc['id'], $this->searchQuery) !== false;
            });
        }

        if (!empty($this->filterBucket)) {
            $accounts = $accounts->where('bucket', $this->filterBucket);
        }

        return $accounts->all();
    }

    public function openPtpModal($accountId)
    {
        $this->selectedAccountId = $accountId;
        $this->ptpDate = '';
        $this->ptpAmount = '';
        $this->ptpNote = '';
        $this->showPtpModal = true;
    }

    public function closePtpModal()
    {
        $this->showPtpModal = false;
        $this->selectedAccountId = null;
    }

    public function savePtp()
    {
        $this->validate([
            'ptpDate' => 'required|date|after_or_equal:today',
            'ptpAmount' => 'required|numeric|min:1',
        ]);

        foreach ($this->arrearsAccounts as $index => $acc) {
            if ($acc['id'] === $this->selectedAccountId) {
                $this->arrearsAccounts[$index]['ptp_date'] = $this->ptpDate;
                $this->arrearsAccounts[$index]['status'] = 'PTP Logged';
            }
        }

        session()->flash('message', 'Promise To Pay (PTP) logged successfully.');
        $this->closePtpModal();
    }

    public function escalateAccount($accountId)
    {
        foreach ($this->arrearsAccounts as $index => $acc) {
            if ($acc['id'] === $accountId) {
                $this->arrearsAccounts[$index]['status'] = 'Escalated';
            }
        }
        session()->flash('message', 'Account escalated successfully.');
    }

    public function render()
    {
        return view('livewire.arrears-dashboard-a3')->layout('layouts.app');
    }
}
