<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasUuids;

    const UPDATED_AT = null;

    protected $fillable = [
        'report_id',
        'assigned_by',
        'operator_id',
        'agency_id',
        'due_date',
        'note',
        'accepted_at',
        'is_active',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'due_date'    => 'date',
        'accepted_at' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
