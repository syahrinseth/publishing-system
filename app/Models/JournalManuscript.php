<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalManuscript extends Model
{
    use HasFactory;

    public function manuscript()
    {
        return $this->hasOne(Manuscript::class, 'id', 'manuscript_id');
    }
}
