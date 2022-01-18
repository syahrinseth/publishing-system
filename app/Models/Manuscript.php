<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manuscript extends Model
{
    use HasFactory;

    protected $table = 'manuscripts';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'authors' => 'array',
        'corresponding_authors' => 'array',
        'editors' => 'array',
        'reviewers' => 'array',
    ];

    /**
     * Store Attach File.
     * 
     * @return Manuscript
     */
    public function storeAttachFile($file)
    {
        // check file format
    }

    /**
     * The attachments that belong to the manuscript.
     */
    public function attachments()
    {
        return $this->hasMany(ManuscriptAttachFile::class, 'manuscript_id', 'id');
    }

    public function getType()
    {
        $types = [
            '1' => "Full Length Article",
            '2' => "Review",
            '3' => "Short Communication"
        ];
        return $types[$this->type];
    }
}
