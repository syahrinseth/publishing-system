<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'settings';

    protected static $logAttributes = ["*"];
    protected static $logOnlyDirty = true;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * Generate Manuscript Number
     * 
     * @param Manuscript $manuscript
     * 
     * @return String
     */
    public function generateManuscriptNo(Manuscript $manuscript)
    {
        
    }
}
