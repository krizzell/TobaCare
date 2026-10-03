<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ReportStatusHistory extends Model
{
    use HasUuids;
    protected $table = 'report_status_history';
    const UPDATED_AT = null;
    protected $fillable = ['report_id', 'from_status', 'to_status', 'changed_by', 'note'];
}
