<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Status extends Model
{
    protected $fillable = ['label', 'statusable_type', 'statusable_id'];
    public function statusable(): MorphTo
    {
        return $this->morphTo();
    }
}
