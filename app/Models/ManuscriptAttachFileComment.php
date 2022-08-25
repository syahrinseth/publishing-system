<?php

namespace App\Models;

use App\Models\User;
use App\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManuscriptAttachFileComment extends Model
{
    use HasFactory;

    protected $table = 'manuscript_attach_file_comments';

    public function attachFile()
    {
        return $this->hasOne(ManuscriptAttachFile::class, 'id');    
    }

    /**
     * @return User
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

    /**
     * @param int $user_id
     * @return String
     * 
     */
    public function isFrom($user_id)
    {
        $manuscriptAttach = ManuscriptAttachFile::find($this->manuscript_attach_id);
        if (!empty($manuscriptAttach)) {
            $manuscript = Manuscript::find($manuscriptAttach->manuscript_id);
            return $manuscript == null ? 'unknown' : $manuscript->findUserRole($user_id);
        }
        return 'unknown';
    }
}