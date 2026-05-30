<div>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10 border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Graduation Assessment (A2)</h2>

        <!-- Client Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <span class="text-gray-500 text-sm">Client Name</span>
                <p class="font-semibold text-lg">{{ $clientData['name'] }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <span class="text-gray-500 text-sm">Client ID</span>
                <p class="font-semibold text-lg">{{ $clientData['client_id'] }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <span class="text-gray-500 text-sm">Current Loan Cycle</span>
                <p class="font-semibold text-lg">{{ $clientData['current_loan_cycle'] }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                <span class="text-gray-500 text-sm">Repayment Rate</span>
                <p class="font-semibold text-lg">{{ $clientData['repayment_rate'] }}%</p>
            </div>
        </div>

        <button wire:click="assessEligibility" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
            Run Graduation Assessment
        </button>

        @if($isEligible !== null)
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Assessment Results</h3>
                
                @if($isEligible)
                    <!-- Graduation Badge -->
                    <div class="flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded text-green-800">
                        <svg class="w-8 h-8 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-lg">Graduation Badge Awarded</h4>
                            <p>This client has met all criteria and is eligible for graduation.</p>
                        </div>
                    </div>
                @else
                    <!-- Gap Notification -->
                    <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded text-yellow-800">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <h4 class="font-bold text-lg">Eligibility Gap Notification</h4>
                        </div>
                        <p class="mb-3 text-sm">The client does not yet meet the graduation criteria. Please review the eligibility gaps below.</p>
                        
                        <div class="bg-white bg-opacity-50 p-4 rounded-md">
                            <h5 class="font-semibold text-gray-700 mb-2">Gap Messages:</h5>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($eligibilityGaps as $gap)
                                    <li class="text-sm text-red-600">{{ $gap }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
