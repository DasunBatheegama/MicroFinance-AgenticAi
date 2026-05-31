<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Microfinance System Navigation</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="antialiased bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 py-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-blue-900 tracking-tight sm:text-5xl">
                    Microfinance Management System
                </h1>
                <p class="mt-4 text-xl text-gray-600">
                    Agentic AI Demo Platform Navigation
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Client Onboarding Group -->
                <a href="/client/register" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border-t-4 border-blue-500 flex flex-col items-center p-6 cursor-pointer">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">1. Client Registration</h3>
                    <p class="text-gray-500 text-sm text-center">Register new clients into the system</p>
                </a>

                <a href="/group/form" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border-t-4 border-indigo-500 flex flex-col items-center p-6 cursor-pointer">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">2. Group Formation</h3>
                    <p class="text-gray-500 text-sm text-center">Assign clients to solidarity groups</p>
                </a>

                <!-- Loan Processing Group -->
                <a href="/loan-application" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border-t-4 border-green-500 flex flex-col items-center p-6 cursor-pointer">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">3. Loan Application</h3>
                    <p class="text-gray-500 text-sm text-center">Process and submit loan applications</p>
                </a>

                <a href="/credit-decision" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border-t-4 border-teal-500 flex flex-col items-center p-6 cursor-pointer">
                    <div class="p-3 rounded-full bg-teal-100 text-teal-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">4. Credit Decision</h3>
                    <p class="text-gray-500 text-sm text-center">Review and approve loan applications</p>
                </a>

                <a href="/disbursement-checklist" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border-t-4 border-cyan-500 flex flex-col items-center p-6 cursor-pointer">
                    <div class="p-3 rounded-full bg-cyan-100 text-cyan-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">5. Disbursement</h3>
                    <p class="text-gray-500 text-sm text-center">Post-approval disbursement checklist</p>
                </a>

                <!-- Repayment & Recovery -->
                <a href="/repayment-posting" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border-t-4 border-yellow-500 flex flex-col items-center p-6 cursor-pointer">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">6. Repayment Posting</h3>
                    <p class="text-gray-500 text-sm text-center">Process client payments</p>
                </a>

                <a href="/arrears-dashboard" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border-t-4 border-red-500 flex flex-col items-center p-6 cursor-pointer">
                    <div class="p-3 rounded-full bg-red-100 text-red-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">7. Arrears Dashboard</h3>
                    <p class="text-gray-500 text-sm text-center">Monitor and manage delayed payments</p>
                </a>

                <!-- Follow Up -->
                <a href="/graduation-assessment" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border-t-4 border-purple-500 flex flex-col items-center p-6 cursor-pointer">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">8. Graduation Assessment</h3>
                    <p class="text-gray-500 text-sm text-center">Assess client readiness for larger loans</p>
                </a>
            </div>
        </div>
    </body>
</html>
