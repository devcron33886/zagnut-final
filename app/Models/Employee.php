<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use Notifiable,SoftDeletes;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }

    public function calculateTotalPayout()
    {
        return $this->works->sum('payout');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($employee) {
            $lastEmployee = static::orderBy('id', 'desc')->first();
            $registrationNumber = 'ZAG-'.sprintf('%05d', ($lastEmployee ? $lastEmployee->id + 1 : 1));
            $employee->code = date('Y').$registrationNumber;
        });
    }
}
