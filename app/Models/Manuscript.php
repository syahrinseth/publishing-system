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
        'additional_informations' => 'array'
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
        $types = collect([
            [
                'id' => 1,
                'name' => "Full Length Article",
            ],
            [
                'id' => 2,
                'name' => "Review",
            ],
            [
                'id' => 3,
                'name' => "Short Communication",
            ],
        ]);
        return $types->where('id', $this->type)->first();
    }

    public static function getTypes()
    {
        return collect([
            [
                'id' => 1,
                'name' => "Full Length Article",
            ],
            [
                'id' => 2,
                'name' => "Review",
            ],
            [
                'id' => 3,
                'name' => "Short Communication",
            ],
        ]);
    }

    public function getCategories()
    {
        return collect([
            [
                'id' => 1,
                'name' => 'Catalytic (whole organism, tissues, cells)'
            ],
            [
                'id' => 2,
                'name' => 'Catalytic (enzyme, biomimetic catalysts)'
            ],
            [
                'id' => 3,
                'name' => 'Affinity (e.g. antibodies & antibody fragments, nanobodies)'
            ],
            [
                'id' => 4,
                'name' => 'Others'
            ],
        ]);
    }
}
