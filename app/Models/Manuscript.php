<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manuscript extends Model
{
    use HasFactory;

    protected $table = 'manuscripts';

    /**
     * Store Attach File.
     * 
     * @return Manuscript
     */
    public function storeAttachFile($file)
    {
        // check file format
    }
}
