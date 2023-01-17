<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalManuscript extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['journal_id', 'manuscript_id'];

    public function manuscript()
    {
        return $this->hasOne(Manuscript::class, 'id', 'manuscript_id');
    }
}
