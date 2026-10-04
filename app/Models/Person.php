<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Person extends Model
{
    use Common, HasTranslations;

    protected $table = 'people';

    protected $guarded = [];

    public const GROUPS = ['leadership', 'management', 'scientific', 'medical', 'administrative', 'doctor'];

    public array $translatable = ['name', 'position', 'specialty', 'bio'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'has_degree' => 'boolean', 'show_on_home' => 'boolean'];
    }

    public function url(): string
    {
        return $this->group === 'doctor'
            ? route('site.doctor', $this->slug)
            : route('site.person', $this->slug);
    }

    public function photoUrl(): string
    {
        return $this->photo ? media_url($this->photo) : asset('assets/img/team-1.png');
    }

    public function summary(int $limit = 110): string
    {
        $text = $this->bio ?: $this->specialty;

        return Str::limit(trim(strip_tags(html_entity_decode((string) $text))), $limit);
    }
}
