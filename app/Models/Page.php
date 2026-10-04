<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use Common, HasTranslations;

    protected $guarded = [];

    public array $translatable = ['title', 'subtitle', 'content', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'is_system' => 'boolean'];
    }

    public function url(): string
    {
        return match ($this->slug) {
            'about', 'citizens', 'ministry', 'international' => route('site.'.$this->slug),
            default => route('site.page', $this->slug),
        };
    }
}
