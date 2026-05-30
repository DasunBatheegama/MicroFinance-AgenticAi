<div class="max-w-6xl mx-auto p-6 bg-white shadow rounded-lg mt-10">
    <div class="flex justify-between items-center border-b pb-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Arrears Dashboard (A3)</h1>
        <div class="text-sm text-gray-500">Manage Collections & Aging Buckets</div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Toolbar: Search & Filter -->
    <div class="flex flex-col md:flex-row gap-4 mb-6 bg-gray-50 p-4 rounded border border-gray-200">
        <div class="w-full md:w-1/2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search Account / Client</label>
            <input type="text" wire:model.live="searchQuery" class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 p-2 border" placeholder="Search by name or ID...">
        </div>
        <div class="w-full md:w-1/4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Bucket</label>
            <select wire:model.live="filterBucket" class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 p-2 border">
                <option value="">All Buckets</option>
                <option value="1-30 Days">1-30 Days</option>
                <option value="31-60 Days">31-60 Days</option>
                <option value="61-90 Days">61-90 Days</option>
                <option value="90+ Days">90+ Days</option>
            </select>
        </div>
    </div>

    <!-- Aging Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-yellow-100 border border-yellow-300 p-4 rounded text-center">
            <div class="text-yellow-800 font-bold text-lg">1-30 Days</div>
            <div class="text-2xl font-extrabold text-yellow-900 mt-2">
                {{ collect($arrearsAccounts)->where('bucket', '1-30 Days')->count() }} Accounts
            </div>
        </div>
        <div class="bg-orange-100 border border-orange-300 p-4 rounded text-center">
            <div class="text-orange-800 font-bold text-lg">31-60 Days</div>
            <div class="text-2xl font-extrabold text-orange-900 mt-2">
                {{ collect($arrearsAccounts)->where('bucket', '31-60 Days')->count() }} Accounts
            </div>
        </div>
        <div class="bg-red-100 border border-red-300 p-4 rounded text-center">
            <div class="text-red-800 font-bold text-lg">61-90 Days</div>
            <div class="text-2xl font-extrabold text-red-900 mt-2">
                {{ collect($arrearsAccounts)->where('bucket', '61-90 Days')->count() }} Accounts
            </div>
        </div>
        <div class="bg-gray-800 border border-gray-900 p-4 rounded text-center">
            <div class="text-gray-100 font-bold text-lg">90+ Days</div>
            <div class="text-2xl font-extrabold text-white mt-2">
                {{ collect($arrearsAccounts)->where('bucket', '90+ Days')->count() }} Accounts
            </div>
        </div>
    </div>

    <!-- Arrears Table -->
    <div class="overflow-x-auto bg-white rounded border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Account ID</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Client Name</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Aging Bucket</th>
                    <th class="px-6 py-3 text-right font-medium text-gray-500 uppercase tracking-wider">Amount Due</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($this->filteredAccounts as $account)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $account['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $account['client_name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $account['bucket'] === '1-30 Days' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $account['bucket'] === '31-60 Days' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $account['bucket'] === '61-90 Days' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $account['bucket'] === '90+ Days' ? 'bg-gray-800 text-white' : '' }}">
                                {{ $account['bucket'] }}
                            </span>
                            <div class="text-xs text-gray-400 mt-1">{{ $account['days_in_arrears'] }} days</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-red-600 font-bold">
                            ${{ number_format($account['amount_due'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700 {{ $account['status'] === 'Escalated' ? 'text-red-600 font-bold' : '' }}">
                                {{ $account['status'] }}
                            </span>
                            @if($account['ptp_date'])
                                <div class="text-xs text-blue-600 mt-1">PTP: {{ $account['ptp_date'] }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button wire:click="openPtpModal('{{ $account['id'] }}')" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded shadow-sm mr-2">
                                Log PTP
                            </button>
                            <button wire:click="escalateAccount('{{ $account['id'] }}')" wire:confirm="Are you sure you want to escalate this account to the next recovery tier?" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded shadow-sm">
                                Escalate
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No accounts matching your criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PTP Modal -->
    @if($showPtpModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg shadow border border-gray-300 w-full max-w-md">
                <h2 class="text-2xl font-bold mb-4 border-b pb-2 text-gray-800">Log Promise To Pay (PTP)</h2>
                <div class="mb-4 text-gray-700 text-sm">
                    Account: <strong>{{ $selectedAccountId }}</strong>
                </div>

                <form wire:submit.prevent="savePtp">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">PTP Date</label>
                        <input type="date" wire:model="ptpDate" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring focus:ring-blue-200">
                        @error('ptpDate') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">PTP Amount ($)</label>
                        <input type="number" step="0.01" wire:model="ptpAmount" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring focus:ring-blue-200">
                        @error('ptpAmount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Notes / Comments</label>
                        <textarea wire:model="ptpNote" rows="3" class="w-full border-gray-300 rounded shadow-sm p-2 border focus:outline-none focus:ring focus:ring-blue-200"></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="closePtpModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Save PTP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
