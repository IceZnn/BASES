<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['group', 'name', 'label'];

    public static function optionsFor(string $group): array
    {
        return static::query()->where('group', $group)->orderBy('label')->pluck('label', 'name')->all();
    }
}
