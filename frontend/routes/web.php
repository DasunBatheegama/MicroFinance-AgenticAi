<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ClientRegistrationForm;
use App\Livewire\GroupFormationWizardA2;
use App\Livewire\LoanApplicationFormA2;
use App\Livewire\CreditDecisionPanelA2;
use App\Livewire\DisbursementChecklistA4;
use App\Livewire\RepaymentPostingFormA4;
use App\Livewire\ArrearsDashboardA3;
use App\Livewire\GraduationAssessmentA2;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/client/register', ClientRegistrationForm::class);
Route::get('/group/form', GroupFormationWizardA2::class);
Route::get('/loan-application', LoanApplicationFormA2::class);
Route::get('/credit-decision', CreditDecisionPanelA2::class);
Route::get('/disbursement-checklist', DisbursementChecklistA4::class);
Route::get('/repayment-posting', RepaymentPostingFormA4::class);
Route::get('/arrears-dashboard', ArrearsDashboardA3::class);
Route::get('/graduation-assessment', GraduationAssessmentA2::class);

