<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class GalleryVideo extends Model
{
    use Common, HasTranslations;

    protected $guarded = [];

    public array $translatable = ['title'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function youtubeId(): ?string
    {
        preg_match('~(?:youtu\.be/|v=|embed/)([\w-]{11})~', (string) $this->youtube_url, $m);

        return $m[1] ?? null;
    }

    public function thumbnailUrl(): string
    {
        if ($this->thumbnail) {
            return media_url($this->thumbnail);
        }

        return $this->youtubeId()
            ? "https://img.youtube.com/vi/{$this->youtubeId()}/hqdefault.jpg"
            : asset('assets/img/news-1.png');
    }
}
