<?php

namespace App\Models;

use App\Models\Manuscript;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManuscriptMember extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'manuscript_members';

    protected static $logAttributes = ["*"];
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'manuscript_id',
        'user_id',
        'role',
        'reviewed',
        'reviewedVote'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Create members from array
     * 
     * @param Manuscript $manuscript
     * @param Array $input
     */
    public static function createMembers(Manuscript $manuscript, $input)
    {

        foreach ($input['authors'] as $key => $value) {
            $user_id = gettype($value) == 'integer' || gettype($value) == 'string' ? $value : $value['id'];
            ManuscriptMember::create([
                'manuscript_id' => $manuscript->id,
                'user_id' => $user_id,
                'role' => 'author'
            ]);
        }

        foreach ($input['corresponding_authors'] as $key => $value) {
            $user_id = gettype($value) == 'integer' || gettype($value) == 'string' ? $value : $value['id'];
            ManuscriptMember::create([
                'manuscript_id' => $manuscript->id,
                'user_id' => $user_id,
                'role' => 'corresponding author'
            ]);
        }

        foreach ($input['editors'] as $key => $value) {
            $user_id = gettype($value) == 'integer' || gettype($value) == 'string' ? $value : $value['id'];
            ManuscriptMember::create([
                'manuscript_id' => $manuscript->id,
                'user_id' => $user_id,
                'role' => 'editor'
            ]);
        }

        foreach ($input['reviewers'] as $key => $value) {
            $user_id = gettype($value) == 'integer' || gettype($value) == 'string' ? $value : $value['id'];
            ManuscriptMember::create([
                'manuscript_id' => $manuscript->id,
                'user_id' => $user_id,
                'role' => 'reviewer'
            ]);
        }

    }
}
