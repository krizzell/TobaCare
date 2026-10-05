<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'parent_id', 'code', 'name', 'default_agency_id', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'category_id');
    }

    public function defaultAgency()
    {
        return $this->belongsTo(Agency::class, 'default_agency_id');
    }
}