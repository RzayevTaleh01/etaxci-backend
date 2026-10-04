<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Common
{
    public function scopeActive(Builder $q): Builder
    {
        return $q->where($this->getTable().'.is_active', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy($this->getTable().'.sort')->orderBy($this->getTable().'.id');
    }
}
