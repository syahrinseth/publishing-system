<?php

namespace App\Models;

use App\Models\Manuscript;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Mail\ManuscriptInviteMemberNotification;
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
        'reviewedVote',
        'status'
    ];

    protected static function booted()
    {
        static::updating(function($member) {
            if ($member->isDirty('status') && $member->status == 'Accepted') {
                // Invite reviewer through email.
                if (!empty($member->user)) {
                    Mail::to($member->user)->queue(new ManuscriptInviteMemberNotification($member->manuscript, $member->user, $member->role));
                }
            }
        });
    }

    public function user() 
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function manuscript()
    {
        return $this->belongsTo(Manuscript::class, 'manuscript_id', 'id');
    }

    /**
     * Create members from array
     * 
     * @param Manuscript $manuscript
     * @param Array $input
     */
    public static function createMembers(Manuscript $manuscript, $input)
    {

        foreach ($input['authors'] ?? [] as $key => $value) {
            $user_id = gettype($value) == 'integer' || gettype($value) == 'string' ? $value : $value['id'];
            if (!Manuscript::memberIsExists(manuscript_id: $manuscript->id, user_id: $user_id, role: 'author')) {
                ManuscriptMember::firstOrCreate([
                    'manuscript_id' => $manuscript->id,
                    'user_id' => $user_id,
                    'role' => 'author'
                ]);
            }
        }

        foreach ($input['corresponding_authors'] ?? [] as $key => $value) {
            $user_id = gettype($value) == 'integer' || gettype($value) == 'string' ? $value : $value['id'];
            if (!Manuscript::memberIsExists(manuscript_id: $manuscript->id, user_id: $user_id, role: 'corresponding author')) {
                ManuscriptMember::firstOrCreate([
                    'manuscript_id' => $manuscript->id,
                    'user_id' => $user_id,
                    'role' => 'corresponding author'
                ]);
            }
            
        }

        foreach ($input['editors'] ?? [] as $key => $value) {
            $user_id = gettype($value) == 'integer' || gettype($value) == 'string' ? $value : $value['id'];
            if (!Manuscript::memberIsExists(manuscript_id: $manuscript->id, user_id: $user_id, role: 'editor')) {
                ManuscriptMember::firstOrCreate([
                    'manuscript_id' => $manuscript->id,
                    'user_id' => $user_id,
                    'role' => 'editor'
                ]);
            }
        }

        foreach ($input['reviewers'] ?? [] as $key => $value) {
            $user_id = gettype($value) == 'integer' || gettype($value) == 'string' ? $value : $value['id'];
            if (!Manuscript::memberIsExists(manuscript_id: $manuscript->id, user_id: $user_id, role: 'reviewer')) {
                ManuscriptMember::firstOrCreate([
                    'manuscript_id' => $manuscript->id,
                    'user_id' => $user_id,
                    'role' => 'reviewer',
                    'status' => 'Pending'
                ]);
            }
        }

    }

    /**
     * Sync members.
     * 
     * @param Manuscript $manuscript
     * @param Array $input
     * 
     * @return Collection
     */
    public static function syncMembers(Manuscript $manuscript, $input, $member = 'author')
    {
        $members = static::query()
            ->where('manuscript_id', $manuscript->id)
            ->where('role', $member)
            ->get();

        foreach ($input as $input_user) {
            $user_id = gettype($input_user) == 'integer' || gettype($input_user) == 'string' ? $input_user : $input_user['id'];
            if ($members->count() == 0) {
                static::firstOrCreate([
                    'manuscript_id' => $manuscript->id,
                    'user_id' => $user_id,
                    'role' => $member
                ]);
            }
            $members = $members->reject(function($value, $key) use ($user_id, $manuscript, $member) {
                if (
                    $value->user_id == $user_id
                ) {
                    return true;
                }
                static::firstOrCreate([
                    'manuscript_id' => $manuscript->id,
                    'user_id' => $user_id,
                    'role' => $member
                ]);
                return false;
            });
        }

        foreach ($members as $toDelete) {
            $toDelete->delete();
        }

        return static::query()
            ->where('manuscript_id', $manuscript->id)
            ->where('role', $member)
            ->get();
    }
}
