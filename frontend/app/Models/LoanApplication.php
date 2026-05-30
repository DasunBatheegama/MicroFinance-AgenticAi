<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'amount',
        'purpose',
        'term_months',
        'status',
        'cashflow_data',
        'credit_memo',
    ];

    protected $casts = [
        'cashflow_data' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
