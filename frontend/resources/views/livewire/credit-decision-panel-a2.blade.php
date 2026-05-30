<div class="max-w-5xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">M-04 Credit Decision Panel A2</h2>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveDecision">
        <!-- Screening Result -->
        <fieldset class="mb-6 p-4 border border-gray-200 rounded bg-gray-50">
            <legend class="text-lg font-semibold text-gray-700 px-2">Screening Result</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($screeningResult as $key => $item)
                    @php
                        $label = is_array($item) ? ($item['label'] ?? $key) : $key;
                        $value = is_array($item) ? ($item['value'] ?? '-') : $item;
                        $status = is_array($item) ? ($item['status'] ?? null) : null;
                        $statusValue = is_string($status) ? strtolower($status) : '';
                        $statusClasses = 'bg-gray-100 text-gray-700';

                        if (in_array($statusValue, ['pass', 'approved', 'clear'])) {
                            $statusClasses = 'bg-green-100 text-green-700';
                        } elseif (in_array($statusValue, ['fail', 'reject', 'blocked'])) {
                            $statusClasses = 'bg-red-100 text-red-700';
                        } elseif (in_array($statusValue, ['review', 'pending', 'flag'])) {
                            $statusClasses = 'bg-yellow-100 text-yellow-700';
                        }
                    @endphp

                    <div class="p-3 border border-gray-200 rounded bg-white">
                        <p class="text-xs uppercase tracking-wide text-gray-500">{{ $label }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-lg font-semibold text-gray-800">{{ $value }}</p>
                            @if ($status)
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $statusClasses }}">
                                    {{ $status }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 italic">No screening data loaded yet.</p>
                @endforelse
            </div>
        </fieldset>

        <!-- Decision & Rationale -->
        <fieldset class="mb-6 p-4 border border-gray-200 rounded">
            <legend class="text-lg font-semibold text-gray-700 px-2">Decision &amp; Rationale</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Decision</label>
                    <div class="mt-2 space-y-2">
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="radio" wire:model="decision" value="approve" class="h-4 w-4 text-indigo-600 border-gray-300">
                            Approve
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="radio" wire:model="decision" value="review" class="h-4 w-4 text-indigo-600 border-gray-300">
                            Need Review
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="radio" wire:model="decision" value="decline" class="h-4 w-4 text-indigo-600 border-gray-300">
                            Decline
                        </label>
                    </div>
                    @error('decision') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Decision Rationale</label>
                    <textarea wire:model.defer="rationale" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" placeholder="Summarize key reasons for the decision."></textarea>
                    @error('rationale') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </fieldset>

        <!-- Maker-Checker Block -->
        <fieldset class="mb-6 p-4 border border-gray-200 rounded bg-gray-50">
            <legend class="text-lg font-semibold text-gray-700 px-2">Maker-Checker Block</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 border border-gray-200 rounded bg-white">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Maker</h4>
                    <label class="block text-sm font-medium text-gray-700">Maker Name</label>
                    <input type="text" wire:model.defer="maker_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" placeholder="Enter maker name">
                </div>

                <div class="p-4 border border-gray-200 rounded bg-white">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Checker</h4>
                    <label class="block text-sm font-medium text-gray-700">Checker Name</label>
                    <input type="text" wire:model.defer="checker_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" placeholder="Enter checker name">
                    <div class="mt-3 flex items-center gap-2">
                        <input id="checker_approved" type="checkbox" wire:model="checker_approved" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="checker_approved" class="text-sm text-gray-700">Checker Approval</label>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="flex justify-end gap-3">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Save Decision
            </button>
        </div>
    </form>
</div>
