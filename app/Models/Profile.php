<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'description',
        'image',
        'image_mime_type', // Fixed: was 'image_mime' in original
        'image_original_name',
    ];

    /**
     * Get the image as base64 data URL
     */
    public function getImageDataUrlAttribute()
    {
        if ($this->image && $this->image_mime_type) {
            return 'data:' . $this->image_mime_type . ';base64,' . base64_encode($this->image);
        }
        return null;
    }

    /**
     * Check if profile has an image
     */
    public function hasImage()
    {
        return !is_null($this->image);
    }
}