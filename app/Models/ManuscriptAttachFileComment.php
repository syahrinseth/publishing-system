<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManuscriptAttachFileComment extends Model
{
    use HasFactory;

    protected $table = 'manuscript_attach_file_comments';

    public function attachFile()
    {
        return $this->hasOne(ManuscriptAttachFile::class, 'id');    
    }
}
