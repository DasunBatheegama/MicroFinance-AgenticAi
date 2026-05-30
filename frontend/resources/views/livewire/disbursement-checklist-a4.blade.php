<div>
    <div class="max-w-4xl mx-auto mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Disbursement Checklist & Readiness Check (A4)
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Confirm conditions status and dual-auth to authorize funds transfer.
            </p>
        </div>

        <div class="px-4 py-5 sm:p-6 border-b border-gray-200">
            <h4 class="text-md font-medium text-gray-900 mb-4">Client Information</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="block text-sm font-medium text-gray-700">Client Name</span>
                    <span class="block text-sm text-gray-900">{{ $client_name }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-700">Loan Amount</span>
                    <span class="block text-sm text-gray-900">${{ number_format($loan_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="px-4 py-5 sm:p-6">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form wire:submit.prevent="authorizeDisbursement">
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">1. Readiness Check Conditions</h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="contracts_signed" wire:model="conditions.contracts_signed" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="contracts_signed" class="font-medium text-gray-700">All contracts and promissory notes signed</label>
                                @error('conditions.contracts_signed') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="collateral_verified" wire:model="conditions.collateral_verified" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="collateral_verified" class="font-medium text-gray-700">Collateral documentation verified and registered</label>
                                @error('conditions.collateral_verified') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="insurance_active" wire:model="conditions.insurance_active" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="insurance_active" class="font-medium text-gray-700">Life/Property insurance active</label>
                                @error('conditions.insurance_active') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="bank_details_confirmed" wire:model="conditions.bank_details_confirmed" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="bank_details_confirmed" class="font-medium text-gray-700">Client bank account details confirmed</label>
                                @error('conditions.bank_details_confirmed') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6 pt-6 border-t border-gray-200">
                    <h4 class="text-md font-medium text-gray-900 mb-4">2. Dual-Auth Confirmation</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Maker Section -->
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <h5 class="text-sm font-medium text-gray-900 mb-2">Maker Confirmation</h5>
                            <div class="flex items-start mt-4">
                                <div class="flex items-center h-5">
                                    <input id="maker_confirmed" wire:model="maker_confirmed" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="maker_confirmed" class="font-medium text-gray-700">I confirm that all readiness checks are completed</label>
                                    @error('maker_confirmed') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Checker Section -->
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <h5 class="text-sm font-medium text-gray-900 mb-2">Checker Authorization</h5>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="checker_username" class="block text-sm font-medium text-gray-700">Checker Username</label>
                                    <input type="text" id="checker_username" wire:model="checker_username" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label for="checker_password" class="block text-sm font-medium text-gray-700">Checker Password</label>
                                    <input type="password" id="checker_password" wire:model="checker_password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" {{ $checker_confirmed ? 'disabled' : '' }}>
                            Authorize & Disburse Funds
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
