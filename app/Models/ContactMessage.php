<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $guarded = [];

    public function fullName(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
