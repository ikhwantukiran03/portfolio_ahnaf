<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'institution',
        'location',
        'description',
        'year',
        'file_type',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'year' => 'integer'
    ];

    /**
     * Scope active certificates
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope ordered certificates
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('year');
    }

    /**
     * Set the certificate file.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setCertificateFileAttribute($value)
    {
        if ($value) {
            $this->attributes['certificate_file'] = $value;
        }
    }

    /**
     * Get the certificate file.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function getCertificateFileAttribute($value)
    {
        return $value;
    }
} 