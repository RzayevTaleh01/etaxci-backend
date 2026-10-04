<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use Common, HasTranslations;

    protected $guarded = [];

    public array $translatable = ['title', 'text', 'button_text'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
