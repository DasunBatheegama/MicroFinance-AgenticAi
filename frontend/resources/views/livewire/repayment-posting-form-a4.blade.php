<div>
    <div class="max-w-4xl mx-auto bg-white p-8 mt-10 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Repayment Posting (A4)</h2>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Side: Loan Details -->
            <div class="bg-gray-50 p-6 rounded border border-gray-200">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Account Details</h3>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-600">Client Name</span>
                    <span class="block text-lg font-bold text-gray-900">{{ $client_name }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-600">Loan Account</span>
                    <span class="block text-lg font-bold text-gray-900">{{ $loan_account_id }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-600">Due Amount</span>
                    <span class="block text-2xl font-bold text-red-600">${{ number_format($due_amount, 2) }}</span>
                </div>
            </div>

            <!-- Right Side: Payment Form -->
            <div class="bg-white p-6 rounded border border-gray-200 shadow-sm">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Post Payment</h3>
                
                <form wire:submit.prevent="processPayment">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Amount Paid</label>
                        <input type="number" step="0.01" wire:model="amount_paid" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('amount_paid') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        
                        @if($amount_paid && $amount_paid < $due_amount)
                            <div class="mt-2 text-sm text-amber-600 font-semibold bg-amber-50 p-2 rounded border border-amber-200">
                                ⚠️ Partial Payment Detected
                            </div>
                        @elseif($amount_paid && $amount_paid > $due_amount)
                            <div class="mt-2 text-sm text-blue-600 font-semibold bg-blue-50 p-2 rounded border border-blue-200">
                                ℹ️ Over Payment Detected
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Payment Method</label>
                        <select wire:model="payment_method" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Mobile Money">Mobile Money</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                        @error('payment_method') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Remarks (Optional)</label>
                        <textarea wire:model="remarks" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out" {{ $receipt_generated ? 'disabled' : '' }}>
                        Process Payment
                    </button>
                </form>
            </div>
        </div>

        <!-- Receipt Section -->
        @if($receipt_generated)
        <div class="mt-10 p-8 border-2 border-dashed border-gray-300 rounded-lg bg-green-50 print:border-solid print:border-gray-800 print:bg-white">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Official Receipt</h3>
                    <p class="text-sm text-gray-500">Microfinance System</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-700">Receipt No: {{ $receipt_details['receipt_no'] }}</p>
                    <p class="text-sm text-gray-500">Date: {{ $receipt_details['date'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-600">Received From:</p>
                    <p class="font-bold text-lg">{{ $receipt_details['client_name'] }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Account No:</p>
                    <p class="font-bold text-lg">{{ $receipt_details['loan_account_id'] }}</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded border mb-6">
                <div class="flex justify-between items-center border-b pb-2 mb-2">
                    <span class="text-gray-600">Amount Due:</span>
                    <span class="font-semibold">${{ $receipt_details['due_amount'] }}</span>
                </div>
                <div class="flex justify-between items-center border-b pb-2 mb-2">
                    <span class="text-gray-600">Amount Paid:</span>
                    <span class="text-xl font-bold text-green-600">${{ $receipt_details['amount_paid'] }}</span>
                </div>
                <div class="flex justify-between items-center border-b pb-2 mb-2">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-bold {{ $receipt_details['status'] === 'Partial Payment' ? 'text-amber-500' : 'text-blue-500' }}">{{ $receipt_details['status'] }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 mb-2">
                    <span class="text-gray-600">Remaining Balance:</span>
                    <span class="font-semibold">{{ $receipt_details['balance'] < 0 ? '($' . abs($receipt_details['balance']) . ')' : '$' . $receipt_details['balance'] }}</span>
                </div>
            </div>

            <div class="flex gap-4 print:hidden">
                <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded w-full">
                    Print Receipt
                </button>
                <button wire:click="resetForm" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded w-full">
                    New Payment
                </button>
            </div>
        </div>
        @endif
    </div>
</div>