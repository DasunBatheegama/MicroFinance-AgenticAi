<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">M-01 Client Registration Form A1</h2>

    <!-- Notifications -->
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submitRegistration">
        <!-- Section: Basic Information -->
        <fieldset class="mb-6 p-4 border border-gray-200 rounded">
            <legend class="text-lg font-semibold text-gray-700 px-2">Basic Information</legend>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Client Name</label>
                    <input type="text" wire:model.defer="clientName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                    @error('clientName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">National Identity Card (NIC)</label>
                    <input type="text" wire:model.debounce.500ms="nic_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                    @if ($duplicateNicWarning)
                        <span class="text-red-600 text-xs font-bold mt-1 block">⚠️ Warning: Duplicate NIC detected! This NIC is already registered.</span>
                    @endif
                    @error('nic_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" wire:model.defer="dateOfBirth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                    @error('dateOfBirth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" wire:model.defer="contactNumber" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                    @error('contactNumber') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Permanent Address</label>
                    <textarea wire:model.defer="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border"></textarea>
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </fieldset>

        <!-- Section: KYC Checklist Panel -->
        <fieldset class="mb-6 p-4 border border-blue-200 bg-blue-50 rounded">
            <legend class="text-lg font-semibold text-blue-800 px-2">Triage KYC Checklist</legend>
            <p class="text-xs text-blue-700 mb-4">Please verify and check the following documents presented by the client.</p>
            
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="flex h-5 items-center">
                        <input id="kycIdentityDoc" wire:model="kycIdentityDoc" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="kycIdentityDoc" class="font-medium text-gray-700">Identity Document verified</label>
                        <p class="text-gray-500">Original NIC/Passport has been checked.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex h-5 items-center">
                        <input id="kycAddressProof" wire:model="kycAddressProof" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="kycAddressProof" class="font-medium text-gray-700">Proof of Address collected</label>
                        <p class="text-gray-500">Utility bill or Grama Niladhari certificate within last 3 months.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex h-5 items-center">
                        <input id="kycPhoto" wire:model="kycPhoto" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="kycPhoto" class="font-medium text-gray-700">Recent Photograph</label>
                        <p class="text-gray-500">Passport-sized photograph collected.</p>
                    </div>
                </div>
            </div>
            @if($errors->has('kycIdentityDoc') || $errors->has('kycAddressProof') || $errors->has('kycPhoto'))
                <div class="mt-2 text-red-500 text-xs">All KYC checklist items must be verified to proceed.</div>
            @endif
        </fieldset>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
            <button type="button" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Cancel
            </button>
            <button type="submit" @if($duplicateNicWarning) disabled @endif class="rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                Submt Registration
            </button>
        </div>
    </form>
</div>