<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'start_date',
        'end_date',
        'type',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute()
    {
        $start = $this->start_date->format('Y');
        $end = $this->end_date ? $this->end_date->format('Y') : 'Present';
        return "{$start} - {$end}";
    }

    /**
     * Scope active experiences
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope work experiences
     */
    public function scopeWork($query)
    {
        return $query->where('type', 'work');
    }

    /**
     * Scope education experiences
     */
    public function scopeEducation($query)
    {
        return $query->where('type', 'education');
    }

    /**
     * Scope ordered experiences
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('start_date');
    }
}
