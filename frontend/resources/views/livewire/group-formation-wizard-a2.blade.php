<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">M-02 Group Loan Group Formation Wizard A2</h2>

    <!-- Notifications -->
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <!-- Overdue Warning Banner -->
    @if ($hasOverdueWarning)
        <div class="p-4 mb-6 text-sm text-yellow-800 bg-yellow-100 border border-yellow-300 rounded-lg flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2 text-yellow-700" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">Warning!</span> &nbsp;One or more selected members have overdue loans. Group formation cannot proceed until dues are cleared.
        </div>
    @endif

    @error('overdue')
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 border border-red-300 rounded-lg" role="alert">
            {{ $message }}
        </div>
    @enderror

    <form wire:submit.prevent="submitFormation">
        <!-- Group Details -->
        <fieldset class="mb-6 p-4 border border-gray-200 rounded">
            <legend class="text-lg font-semibold text-gray-700 px-2">Group Details</legend>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Group Name</label>
                <input type="text" wire:model.defer="groupName" class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                @error('groupName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </fieldset>

        <!-- Selected Members -->
        <fieldset class="mb-6 p-4 border border-gray-200 rounded">
            <legend class="text-lg font-semibold text-gray-700 px-2">Selected Members ({{ count($selectedMembers) }} / 3)</legend>
            
            @if(count($selectedMembers) == 0)
                <p class="text-sm text-gray-500 italic">No members selected yet.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($selectedMembers as $member)
                        <div class="p-3 border rounded-lg {{ $member['has_overdue'] ? 'border-yellow-400 bg-yellow-50' : 'border-green-400 bg-green-50' }} flex justify-between items-center">
                            <div>
                                <p class="font-bold text-sm text-gray-800">{{ $member['name'] }}</p>
                                <p class="text-xs text-gray-600">NIC: {{ $member['nic'] }}</p>
                                @if($member['has_overdue'])
                                    <span class="text-xs font-bold text-red-600">⚠ Overdue</span>
                                @endif
                            </div>
                            <button type="button" wire:click="removeMember({{ $member['id'] }})" class="text-red-600 hover:text-red-800 focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            @error('members') <span class="text-red-500 text-xs block mt-2">{{ $message }}</span> @enderror
            @error('selectedMembers.size') <span class="text-red-500 text-xs block mt-2">{{ $message }}</span> @enderror
        </fieldset>

        <!-- Member Selection (Eligibility) -->
        <fieldset class="mb-6 p-4 border border-gray-200 rounded">
            <legend class="text-lg font-semibold text-gray-700 px-2">Select Members</legend>

            <div class="mb-4">
                <input type="text" wire:model.debounce.300ms="search" placeholder="Search by name or NIC..." class="block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
            </div>

            <div class="overflow-y-auto max-h-60 border border-gray-200 rounded-md">
                <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 font-medium text-gray-700">Client Name</th>
                            <th class="px-4 py-2 font-medium text-gray-700">NIC</th>
                            <th class="px-4 py-2 font-medium text-gray-700">Status</th>
                            <th class="px-4 py-2 font-medium text-gray-700 w-24">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($clients as $client)
                            @php
                                $isSelected = collect($selectedMembers)->contains('id', $client['id']);
                                $disabled = $isSelected || count($selectedMembers) >= 3;
                            @endphp
                            <tr class="{{ $isSelected ? 'bg-indigo-50' : '' }}">
                                <td class="px-4 py-3 text-gray-800">
                                    {{ $client['name'] }}
                                    @if($client['has_overdue'])
                                        <span class="inline-flex items-center rounded-md bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800 ml-2">Overdue</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $client['nic'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">{{ $client['status'] }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if($isSelected)
                                        <button type="button" class="text-xs px-3 py-1 bg-gray-300 text-gray-700 rounded-md cursor-not-allowed" disabled>Selected</button>
                                    @else
                                        <button type="button" wire:click="addMember({{ $client['id'] }})" class="text-xs px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none transition {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $disabled ? 'disabled' : '' }}>
                                            Add
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500 italic">No clients found matching criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </fieldset>

        <div class="flex justify-end gap-3 mt-6">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 flex items-center transition disabled:opacity-50" {{ $hasOverdueWarning || count($selectedMembers) != 3 ? 'disabled' : '' }}>
                Form Group
            </button>
        </div>
    </form>
</div>
