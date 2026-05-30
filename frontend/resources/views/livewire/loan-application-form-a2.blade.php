<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-xl font-bold mb-6 text-gray-800">M-03 Loan Application (A2)</h2>
        
        <form wire:submit.prevent="submitApplication">
            <!-- General Loan Info -->
            <div class="mb-8 p-4 border rounded bg-gray-50">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Loan Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Requested Amount</label>
                        <input type="number" wire:model.live="requestedAmount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Term (Months)</label>
                        <input type="number" wire:model.live="termMonths" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Interest Rate (% per month)</label>
                        <input type="number" step="0.1" wire:model.live="interestRate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Loan Purpose</label>
                        <input type="text" wire:model="loanPurpose" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <!-- Cashflow Worksheet -->
            <div class="mb-8 p-4 border rounded bg-gray-50">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Cashflow Worksheet</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Monthly Income</label>
                        <input type="number" wire:model.live="monthlyIncome" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Monthly Business Expenses</label>
                        <input type="number" wire:model.live="monthlyBusinessExpenses" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Monthly Household Expenses</label>
                        <input type="number" wire:model.live="monthlyHouseholdExpenses" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Other Debt Obligations</label>
                        <input type="number" wire:model.live="otherDebtObligations" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>

            <!-- Affordability Indicator -->
            <div class="mb-8 p-4 border rounded {{ $isAffordable ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                <h3 class="text-lg font-semibold mb-4 {{ $isAffordable ? 'text-green-800' : 'text-red-800' }}">Affordability Indicator</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-sm font-bold text-gray-600">Net Disp. Income</p>
                        <p class="text-xl font-bold">{{ number_format($netDisposableIncome, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-600">Proposed Installment</p>
                        <p class="text-xl font-bold">{{ number_format($proposedInstallment, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-600">Affordability Ratio</p>
                        <p class="text-xl font-bold {{ $affordabilityRatio > 40 ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($affordabilityRatio, 2) }}%
                        </p>
                    </div>
                </div>
            </div>

            <!-- Credit Memo Draft -->
            <div class="mb-8 p-4 border rounded bg-gray-50">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Auto-Generated Credit Memo Draft</h3>
                <textarea wire:model="creditMemoDraft" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>
