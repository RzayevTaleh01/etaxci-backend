<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FeatureCard extends Model
{
    use Common, HasTranslations;

    protected $guarded = [];

    public array $translatable = ['title', 'text'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function link(): string
    {
        return localized_url($this->url);
    }
}
