<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ManuscriptMember extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'manuscript_members';

    protected static $logAttributes = ["*"];
    protected static $logOnlyDirty = true;

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
