<?php

namespace App\Models;

use App\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManuscriptComment extends Model
{
    use HasFactory;

    protected $table = 'manuscript_comments';

    /**
     * The attachments that belong to the manuscript.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Scoped Filter method.
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
