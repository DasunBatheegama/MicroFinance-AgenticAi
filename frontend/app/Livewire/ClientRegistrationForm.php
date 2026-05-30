<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client; // Assuming Client model exists

class ClientRegistrationForm extends Component
{
    public $clientName;
    public $nic_number;
    public $dateOfBirth;
    public $address;
    public $contactNumber;
    
    // KYC Checklist
    public $kycIdentityDoc = false;
    public $kycAddressProof = false;
    public $kycPhoto = false;

    // Warnings
    public $duplicateNicWarning = false;

    // Rules
    protected $rules = [
        'clientName' => 'required|min:3',
        'nic_number' => 'required',
        'dateOfBirth' => 'required|date',
        'address' => 'required',
        'contactNumber' => 'required|numeric',
        'kycIdentityDoc' => 'accepted',
        'kycAddressProof' => 'accepted',
        'kycPhoto' => 'accepted',
    ];

    public function updatedNicNumber()
    {
        // Simple logic to detect duplicate NIC
        // Replace with real database call like Client::where('nic', $this->nic_number)->exists()
        if (strlen($this->nic_number) >= 9) {
            $exists = Client::where('nic_number', $this->nic_number)->exists();
            $this->duplicateNicWarning = $exists;
        } else {
            $this->duplicateNicWarning = false;
        }
    }

    public function submitRegistration()
    {
        $this->validate();

        if ($this->duplicateNicWarning) {
            session()->flash('error', 'Cannot proceed due to Duplicate NIC.');
            return;
        }

        // Save client logic goes here
        Client::create([
            'name' => $this->clientName,
            'nic_number' => $this->nic_number,
            // ...
        ]);

        session()->flash('message', 'Client Registration successful.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.client-registration-form');
    }
}
