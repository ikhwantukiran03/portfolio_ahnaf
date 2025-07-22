<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_type',
        'client',
        'tag'
    ];

    public const TAGS = [
        'Document Translation',
        'Localization',
        'Transcription and Translation',
        'Subtitling and Captioning',
        'Interpretation',
        'Proofreading and Editing of Translations'
    ];

    /**
     * Set the portfolio file.
     */
    public function setPortfolioFileAttribute($value)
    {
        if ($value) {
            $this->attributes['portfolio_file'] = $value;
        }
    }

    /**
     * Get the portfolio file.
     */
    public function getPortfolioFileAttribute($value)
    {
        return $value;
    }
} 