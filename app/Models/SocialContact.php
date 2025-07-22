<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'custom_type',
        'label',
        'value',
        'icon',
        'description',
        'is_primary',
        'is_public',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_public' => 'boolean',
    ];

    /**
     * Available contact types with default icons
     */
    public static function getContactTypes()
    {
        return [
            'email' => [
                'label' => 'Email',
                'icon' => 'fas fa-envelope',
                'prefix' => 'mailto:'
            ],
            'phone' => [
                'label' => 'Phone',
                'icon' => 'fas fa-phone',
                'prefix' => 'tel:'
            ],
            'linkedin' => [
                'label' => 'LinkedIn',
                'icon' => 'fab fa-linkedin',
                'prefix' => ''
            ],
            'github' => [
                'label' => 'GitHub',
                'icon' => 'fab fa-github',
                'prefix' => ''
            ],
            'twitter' => [
                'label' => 'Twitter',
                'icon' => 'fab fa-twitter',
                'prefix' => ''
            ],
            'facebook' => [
                'label' => 'Facebook',
                'icon' => 'fab fa-facebook',
                'prefix' => ''
            ],
            'instagram' => [
                'label' => 'Instagram',
                'icon' => 'fab fa-instagram',
                'prefix' => ''
            ],
            'website' => [
                'label' => 'Website',
                'icon' => 'fas fa-globe',
                'prefix' => ''
            ],
            'behance' => [
                'label' => 'Behance',
                'icon' => 'fab fa-behance',
                'prefix' => ''
            ],
            'dribbble' => [
                'label' => 'Dribbble',
                'icon' => 'fab fa-dribbble',
                'prefix' => ''
            ],
            'youtube' => [
                'label' => 'YouTube',
                'icon' => 'fab fa-youtube',
                'prefix' => ''
            ],
            'telegram' => [
                'label' => 'Telegram',
                'icon' => 'fab fa-telegram',
                'prefix' => ''
            ],
            'whatsapp' => [
                'label' => 'WhatsApp',
                'icon' => 'fab fa-whatsapp',
                'prefix' => 'https://wa.me/'
            ],
            'skype' => [
                'label' => 'Skype',
                'icon' => 'fab fa-skype',
                'prefix' => 'skype:'
            ],
            'other' => [
                'label' => 'Other',
                'icon' => 'fas fa-link',
                'prefix' => ''
            ]
        ];
    }

    /**
     * Scope active contacts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope public contacts
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope primary contacts
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope ordered contacts
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get contacts by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the display type name (custom type for 'other', or default type)
     */
    public function getDisplayTypeAttribute()
    {
        if ($this->type === 'other' && $this->custom_type) {
            return $this->custom_type;
        }
        
        $types = self::getContactTypes();
        return $types[$this->type]['label'] ?? ucfirst($this->type);
    }

    /**
     * Get the effective type for grouping (use custom_type if type is 'other')
     */
    public function getEffectiveTypeAttribute()
    {
        return $this->type === 'other' && $this->custom_type 
            ? $this->custom_type 
            : $this->type;
    }
    /**
     * Get the default icon for the contact type
     */
    public function getDefaultIconAttribute()
    {
        $types = self::getContactTypes();
        return $types[$this->type]['icon'] ?? 'fas fa-link';
    }

    /**
     * Get the display icon (custom or default)
     */
    public function getDisplayIconAttribute()
    {
        return $this->icon ?: $this->default_icon;
    }

    /**
     * Get the clickable URL for the contact
     */
    public function getUrlAttribute()
    {
        $types = self::getContactTypes();
        $prefix = $types[$this->type]['prefix'] ?? '';

        // For emails and phones, add prefix if not already present
        if (in_array($this->type, ['email', 'phone']) && !str_starts_with($this->value, $prefix)) {
            return $prefix . $this->value;
        }

        // For URLs, ensure they start with http if they don't have a protocol
        if (in_array($this->type, ['website', 'linkedin', 'github', 'twitter', 'facebook', 'instagram', 'behance', 'dribbble', 'youtube', 'other']) 
            && !str_starts_with($this->value, 'http') 
            && !str_starts_with($this->value, 'mailto:')
            && !str_starts_with($this->value, 'tel:')) {
            return 'https://' . $this->value;
        }

        // For WhatsApp, format phone number
        if ($this->type === 'whatsapp') {
            $phone = preg_replace('/[^0-9]/', '', $this->value);
            return $prefix . $phone;
        }

        return $this->value;
    }

    /**
     * Get formatted display value
     */
    public function getDisplayValueAttribute()
    {
        switch ($this->type) {
            case 'email':
                return $this->value;
            case 'phone':
                // Format phone number for display
                $phone = preg_replace('/[^0-9]/', '', $this->value);
                if (strlen($phone) === 10) {
                    return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
                }
                return $this->value;
            case 'website':
                return str_replace(['http://', 'https://'], '', $this->value);
            default:
                return $this->value;
        }
    }

    /**
     * Check if contact type supports multiple entries
     */
    public function getSupportsMultipleAttribute()
    {
        return in_array($this->type, ['email', 'phone', 'website']);
    }

    /**
     * Boot method to handle primary contact logic
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($contact) {
            // If this is being set as primary, unset other primary contacts of the same effective type
            if ($contact->is_primary) {
                $effectiveType = $contact->type === 'other' && $contact->custom_type 
                    ? $contact->custom_type 
                    : $contact->type;
                    
                static::where(function($query) use ($effectiveType, $contact) {
                    $query->where('type', $contact->type);
                    if ($contact->type === 'other') {
                        $query->where('custom_type', $contact->custom_type);
                    }
                })
                ->where('id', '!=', $contact->id)
                ->update(['is_primary' => false]);
            }
        });
    }
}