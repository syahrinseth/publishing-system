<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\QueryFilter;
use App\Models\ManuscriptMember;
use App\Models\JournalManuscript;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ManuscriptCreated;
use App\Mail\ManuscriptEditorNotification;
use App\Notifications\ManuscriptPublished;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ManuscriptInviteMember;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ManuscriptAttachCreated;
use App\Notifications\ManuscriptAttachUpdated;
use App\Notifications\ManuscriptReviewedThanks;
use App\Mail\ManuscriptPostReviewedNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Mail\ManuscriptRejectedInviteToResubmitNotification;

class Manuscript extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'manuscripts';

    protected static $logAttributes = ["*"];
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'type',
        'title',
        'category',
        'short_title',
        'abstract',
        'keywords',
        'funding_information',
        'is_confirm_grant_numbers',
        'is_acknowledge',
        'date_published',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_published' => 'datetime'
    ];

    public static $types = [
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
    ];

    public static $statusList = [
        [
            'name' => "Draft",
            'color' => 'gray'
        ],
        [
            'name' => "Submit For Review",
            'color' => 'blue'
        ],
        [
            'name' => "Rejected Invite To Resubmit",
            'color' => 'red'
        ],
        [
            'name' => "Rejected",
            'color' => 'red'
        ],
        [
            'name' => "Accepted Without Changes",
            'color' => 'green'
        ],
        [
            'name' => "Accepted With Minor Changes",
            'color' => 'green'
        ],
        [
            'name' => "Accepted With Major Changes",
            'color' => 'green'
        ],
        [
            'name' => "Published",
            'color' => 'indigo'
        ],
        [
            'name' => "Submit To Editor",
            'color' => 'blue'
        ],
    ];

    protected static function booted()
    {
        static::created(function($manuscript) {
            $manuscript->generateManuscriptNumber();
            $manuscript->update();
        });

        static::updating(function($manuscript) {
            
        });
    }

    /**
     * Get authors collection
     * @return Collection
     */
    public function authors()
    {
        return $this->hasMany(ManuscriptMember::class, 'manuscript_id', 'id')->where('role', 'author');
    }

    public function getAuthors()
    {
        return $this->belongsToMany(User::class, 'manuscript_members', 'manuscript_id', 'user_id')->where('manuscript_members.role', '=', 'author');
    }

    public function getCoAuthors()
    {
        return $this->belongsToMany(User::class, 'manuscript_members', 'manuscript_id', 'user_id')->where('manuscript_members.role', '=', 'corresponding author');
    }

    public function getEditors()
    {
        return $this->belongsToMany(User::class, 'manuscript_members', 'manuscript_id', 'user_id')->where('manuscript_members.role', '=', 'editor');
    }

    public function getReviewers()
    {
        return $this->belongsToMany(User::class, 'manuscript_members', 'manuscript_id', 'user_id')->where('manuscript_members.role', '=', 'reviewer');
    }

    /**
     * Get corresponding authors collection
     * @return Collection
     */
    public function correspondingAuthors()
    {
        return $this->hasMany(ManuscriptMember::class, 'manuscript_id', 'id')->where('role', 'corresponding author');
    }

    /**
     * Get editors collection
     * @return Collection
     */
    public function editors()
    {
        return $this->hasMany(ManuscriptMember::class, 'manuscript_id', 'id')->where('role', 'editor');
    }

    /**
     * Get reviewers collection
     * @return Collection
     */
    public function reviewers()
    {
        return $this->hasMany(ManuscriptMember::class, 'manuscript_id', 'id')->where('role', 'reviewer');
    }

    /**
     * Scoped Filter method.
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

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
        $types = collect(Manuscript::$types);
        return $types->where('id', $this->type)->first();
    }

    public static function getTypes()
    {
        return collect(Manuscript::$types);
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

    /**
     * Get status list depend on user role on the manuscript.
     * @param int $manuscript_id
     * @return collect
     */
    public static function getStatusList($manuscript_id)
    {
        $list = collect(Manuscript::$statusList);
        // $manuscript = Manuscript::findOrFail($manuscript_id);
        // // if ($manuscript->authIsEditor()) {
        // //     return $list->whereIn('name', ['Draft', "Submit For Review"]);
        // // } elseif($manuscript->authIsReviewer()) {
        // //     return $list->whereIn('name', ['Draft', "Submit For Review", "Rejected", "Approved"]);
        // // } elseif($manuscript->authIsPublisher()) {
        // //     return $list->whereIn('name', ['Draft', "Submit For Review", "Rejected", "Approved", "Published"]);
        // // }
        return $list;
    }

    /**
     * Assign status.
     * @param String $input
     * @return bool
     */
    public function assignStatus($input)
    {
        $statusList = Manuscript::$statusList;
        
        if (
            /* Validate if is author and editor and status is Draft and Submit For Review and Submit to editor */
            ($this->authIsEditor() || $this->authIsAuthor()) && 
            in_array($input, [$statusList[0]['name'], $statusList[1]['name'], $statusList[8]['name']])
        ) {
            $this->status = $input;
            $this->update();
            $this->refreshReviewersReviewLog();

            // Send notification to reviewers.
            if ($statusList[1]['name'] == $input) {
                $reviewers = $this->reviewers->map(function($q){return $q->user;})->values()->all();
                if (!empty($reviewers)) {
                    // Send notifications to reviewers.
                    User::mailTo($reviewers, ManuscriptReviewNotification::class, $this);
                }
            }

            // Send notification to editor.
            if ($statusList[8]['name'] == $input) {
                $editors = $this->editors->map(function($q){return $q->user;})->values()->all();
                if (!empty($editors)) {
                    // Send notifications to editors.
                    User::mailTo($editors, ManuscriptEditorNotification::class, $this);
                }
            }
            return true;
        
        } elseif (
            /* Validate if is reviewer and status is Draft and %Rejected%, %Accepted% */
            $this->authIsReviewer() && 
            in_array($input, [$statusList[2]['name'], $statusList[3]['name'], $statusList[4]['name'], $statusList[5]['name'], $statusList[6]['name']])
        ) {
            // Update member reviewed
            $reviewer = $this->reviewers->where('user_id', auth()->id())->first();
            if (!empty($reviewer)) {

                // Update reviewer vote.
                $reviewer->reviewed = Carbon::now();
                $reviewer->reviewedVote = $input;
                $reviewer->update();

                // Validate manuscript review status and update status based on reviewers votes.
                if ($this->setManuscriptStatusForReviewers($input)) {
                    $this->update();
                    // Send notification to the rest of the members.
                    $this->notifyMembersForPostReviewed();
                };

                // Send thanks notification
                // Mail::to($reviewer->user->email)->queue(new ManuscriptReviewThanksNotification($this));
                Notification::send($reviewer->user, new ManuscriptReviewedThanks($this));

            }
            return true;
        
        } elseif(
            // user can publish and manuscript published
            auth()->user()->can('manuscripts.publish') && 
            in_array($input, [$statusList[7]['name']])
        ) {
        
            $this->status = $input;
            $this->date_published = Carbon::now();
            $this->update();
            $this->notifyMembersForPublished();
            return true;
        
        }
        
        return false;
    
    }

    public function refreshReviewersReviewLog()
    {
        $this->reviewers()->update([
            'reviewed' => null,
            'reviewedVote' => null
        ]);
        return $this;
    }

    /**
     * Get auth role in the manuscript.
     * @return boolean
     */
    public function authIs()
    {
        // Validate Publisher
        // Validate Editor
        // Validate Reviewer
        // Validate Author
    }

    /**
     * Validate if auth is author of the manuscript.
     * @return boolean
     */
    public function authIsAuthor()
    {
        if (in_array(Auth::user()->id, $this->authors->map(function($q){return $q->user_id;})->all() ?? [])) {
            return true;
        } elseif(in_array(Auth::user()->id, $this->correspondingAuthors->map(function($q){return $q->user_id;})->all() ?? [])) {
            return true;
        }
        return false;
    }

    /**
     * Validate if auth is editor of the manuscript.
     * @return boolean
     */
    public function authIsEditor()
    {
        if (in_array(Auth::user()->id, $this->editors->map(function($q){return $q->user_id;})->all() ?? [])) {
            return true;
        }
        return false;
    }

    /**
     * Validate if auth is reviewer of the manuscript.
     * @return boolean
     */
    public function authIsReviewer()
    {
        // return static::whereHas('members', function($q) {
        //     $q->where('role', 'reviewer')
        //         ->where('user_id', auth()->id());
        // })->exists();

        return $this->reviewers()->where('user_id', auth()->id())->exists();
    }

    /**
     * Generate Manuscript Number
     * @return boolean
     */
    public function generateManuscriptNumber()
    {
        $setting = Setting::where('name', 'manuscript_number_prefix')->first();
        if (!empty($setting)) {
            $this->manuscript_no = $setting->value . $this->id;
        }
        return $this;
    }

    /**
     * Get user role in the manuscript.
     * @return String
     */
    public function findUserRole()
    {
        $tempRole = 'unknown';
        // Find author
        $members = ManuscriptMember::where('user_id', auth()->id());

        if ($members->where('role', 'author')->exists()) {
            $tempRole = 'author';
        } elseif ($members->where('role', 'corresponding author')->exists()) {
            $tempRole = 'corresponding author';
        } elseif ($members->where('role', 'reviewer')->exists()) {
            $tempRole = 'reviewer';
        } elseif ($members->where('role', 'editor')->exists()) {
            $tempRole = 'editor';
        } elseif(auth()->can('manuscripts.show_all') && auth()->can('manuscripts.publish')) {
            $tempRole = 'publisher';
        }
        return $tempRole;
    }

    /**
     * Get members from the manuscript.
     * 
     * @return Collection
     */
    public function members()
    {
        return $this->hasMany(ManuscriptMember::class, 'manuscript_id', 'id');
    }

    /**
     * Assign co author.
     * @param User $user
     * 
     * @return Manuscript
     */
    public function assignCoAuthor($user)
    {
        $member = new ManuscriptMember();
        $member->manuscript_id = $this->id;
        $member->user_id = $user->id;
        $member->role = 'corresponding author';
        $member->save();
        return $this;
    }

    /**
     * Set authors.
     * @param Collection || Array $users
     * 
     * @return Manuscript
     */
    public function setAuthors($users)
    {
        return $this->setMembers($users, 'author');
    }

    /**
     * Set co authors.
     * @param Collection || Array $users
     * 
     * @return Manuscript
     */
    public function setCoAuthors($users)
    {
        return $this->setMembers($users, 'corresponding author');
    }

    /**
     * Set reviewers.
     * @param Collection || Array $users
     * 
     * @return Manuscript
     */
    public function setReviewers($users)
    {
        return $this->setMembers($users, 'reviewer');
    }

    /**
     * Set editors.
     * @param Collection || Array $users
     * 
     * @return Manuscript
     */
    public function setEditors($users)
    {
        return $this->setMembers($users, 'editor');
    }

    /**
     * Set members
     * @param Collection $users
     * @param String $roleName
     * 
     * @return Manuscript
     */
    protected function setMembers($users, $roleName)
    {
        $members = $this->members->where('role', $roleName);
        foreach ($users as $user) {
            if ($members->where('user_id', $user->id)->count() > 0) {
                $members = $members->where('user_id', '!=', $user->id);
            } else {
                $member = new ManuscriptMember();
                $member->manuscript_id = $this->id;
                $member->user_id = $user->id;
                $member->role = $roleName;
                $member->save();
                // Send Invitation Notification
                // Mail::to($user)->queue(new ManuscriptInviteMemberNotification($this, $user, $roleName));
                Notification::send($user, new ManuscriptInviteMember($this, $user, $roleName));
            }
        }
        foreach ($members as $member) {
            $m = ManuscriptMember::find($member->id);
            if (!empty($m)) {
                $m->delete();
            }
        }
        return $this;
    }

    /**
     * Send update notification email.
     * @return Manuscript
     */
    public function notifyUpdateManuscript()
    {
        $users = [];
        $users = array_merge($users, $this->correspondingAuthors->map(function($member) {
            return $member->user;
        })->values()->all());

        $users = array_merge($users, $this->authors->map(function($member) {
            return $member->user;
        })->values()->all());

        $users = array_merge($users, $this->editors->map(function($member) {
            return $member->user;
        })->values()->all());

        $users = collect($users)->unique()->all();
        
        if (!empty($users)) {
            User::mailTo($users, ManuscriptUpdated::class, $this);
        }
        return $this;
    }

    /**
     * Send create notification email.
     * @return Manuscript
     */
    public function notifyCreateManuscript()
    {
        foreach ($this->correspondingAuthors as $value) {
            Notification::send($value->user, new ManuscriptCreated($this));
        }

        foreach ($this->authors as $value) {
            Notification::send($value->user, new ManuscriptCreated($this));
        }

        foreach ($this->editors as $value) {
            Notification::send($value->user, new ManuscriptCreated($this));
        }

        return $this;

    }

    /**
     * Send email notification to members (Authors, co authors, editors, publishers if accept).
     * 
     * @return Manuscript
     */
    public function notifyMembersForPostReviewed()
    {
        $users = [];
        $users = array_merge($users, $this->correspondingAuthors->map(function($member) {
            return $member->user;
        })->values()->all());

        $users = array_merge($users, $this->authors->map(function($member) {
            return $member->user;
        })->values()->all());

        $users = array_merge($users, $this->editors->map(function($member) {
            return $member->user;
        })->values()->all());
        
        if (stripos($this->status, "Accepted") !== false) {  
            $publishers = User::permission(['manuscripts.publish'])->permission('manuscripts.show_all')->get();
            // Send mail to publishers.
            if (!empty($publishers)) {
                User::mailTo($publishers, ManuscriptPostReviewedNotification::class, $this);
            }
        } elseif ($this->status == 'Rejected Invite To Resubmit') {
            $users = collect($users)->unique()->all();
        
            if (!empty($users)) {
                User::mailTo($users, ManuscriptRejectedInviteToResubmitNotification::class, $this);
            }
            return $this;
        }

        $users = collect($users)->unique()->all();
        
        if (!empty($users)) {
            User::mailTo($users, ManuscriptPostReviewedNotification::class, $this);
        }

        return $this;
    }

    /**
     * Notify members for published manuscripts.
     * 
     * @return Manuscripts
     */
    public function notifyMembersForPublished()
    {
        $users = [];

        foreach ($this->correspondingAuthors as $value) {
            Notification::send($value->user, new ManuscriptPublished($this));
        }

        foreach ($this->authors as $value) {
            Notification::send($value->user, new ManuscriptPublished($this));
        }

        foreach ($this->editors as $value) {
            Notification::send($value->user, new ManuscriptPublished($this));
        }

        return $this;
    }

    /**
     * Set manuscript review status based on reviewers vote.
     * @param String $status
     * 
     * @return boolean
     */
    public function setManuscriptStatusForReviewers($status)
    {
        // Validate if auth is reviewer.
        if (!$this->authIsReviewer()) {
            return false;
        }

        // Set vote to current member
        $authMember = ManuscriptMember::where('user_id', auth()->id())
            ->where('manuscript_id', $this->id)
            ->where('role', 'reviewer')
            ->first();
        
        if (empty($authMember)) {
            return false;
        }

        $authMember->update([
            'reviewed' => Carbon::now(),
            'reviewedVote' => $status
        ]);

        // Get all reviewers.
        $allReviewers = $this->reviewers;

        // Get reviewers with vote.
        $votedReviewers = $this->reviewers->where('reviewed', '!=', null);

        // If all reviewers has voted set get the status with majority voted.
        if ($allReviewers->count() != $votedReviewers->count()) {
            return false;
        }

        $groupedVote = ManuscriptMember::where('manuscript_id', $this->id)
            ->where('role', 'reviewer')
            ->get()
            ->groupBy('reviewedVote');

        $topVote = [
            'count' => 0,
            'name' => null
        ];

        foreach ($groupedVote as $key => $vote) {
            
            if ($topVote['count'] < $vote->count()) {
                $topVote['count'] = $vote->count();
                $topVote['name'] = $key;
            }

            if (str_contains($key, 'Rejected')) {
                $topVote['count'] = $vote->count();
                $topVote['name'] = $key;
                break;
            }

        }

        // Validate top vote.
        $this->status = $topVote['name'];
        $this->update();

        return true;
    }

    public function journal()
    {
        return $this->hasOne(JournalManuscript::class, 'manuscript_id', 'id');
    }

    /**
     * Notify members for update attach file.
     * @param ManuscriptAttachFile $attach
     * 
     * @return boolean
     */
    public function notifyUpdateAttachToMembers($attach)
    {
        $emails = [];

        foreach ($this->correspondingAuthors as $coAuthor) {
            Notification::send($coAuthor->user, new ManuscriptAttachUpdated($this, $attach));
        }

        foreach ($this->authors as $author) {
            Notification::send($author->user, new ManuscriptAttachUpdated($this, $attach));
        }

        foreach ($this->editors as $editor) {
            Notification::send($editor->user, new ManuscriptAttachUpdated($this, $attach));
        }

        if ($attach->type == 1 && $this->status != "Draft") {
            foreach ($this->reviewers as $reviewer) {
                Notification::send($reviewer->user, new ManuscriptAttachUpdated($this, $attach));
            }
        }
    }

    /**
     * Notify members for create attach file.
     * @param ManuscriptAttachFile $attach
     * 
     * @return boolean
     */
    public function notifyCreateAttachToMembers($attach)
    {
        $emails = [];

        foreach ($this->correspondingAuthors as $coAuthor) {
            Notification::send($coAuthor->user, new ManuscriptAttachCreated($this, $attach));
        }

        foreach ($this->authors as $author) {
            Notification::send($author->user, new ManuscriptAttachCreated($this, $attach));
        }

        foreach ($this->editors as $editor) {
            Notification::send($editor->user, new ManuscriptAttachCreated($this, $attach));
        }

        if ($attach->type == 1 && $this->status != "Draft") {
            foreach ($this->reviewers as $reviewer) {
                Notification::send($reviewer->user, new ManuscriptAttachCreated($this, $attach));
            }
        }
    }

    /**
     * Validate if member is exist in manuscript.
     * @param int $manuscript_id
     * @param int $user_id
     * @param int $role
     * 
     * @return boolean
     */
    public static function memberIsExists($manuscript_id, $user_id, $role)
    {
        return ManuscriptMember::where('manuscript_id', $manuscript_id)
            ->where('user_id', $user_id)
            ->where('role', $role)
            ->exists();
    }

    /**
     * 
     */
    public static function permissionMiddleware()
    {
        $obj = static::query();
        if (auth()?->user()?->can('manuscripts.show_all')) {
            // Can view all accept draft that not belongs to the user
            $obj->where(function($q) {
                $q->where('status', '=', 'Draft')
                    ->whereHas('members', function($q) {
                        $q->where('user_id', auth()->id())
                            ->where('role', '=', 'Author');
                    });
            })
                ->orWhere('status', '!=', 'Draft');
        } else {
            // cannot view all
            $obj->whereHas('members', function($q) {
                $q->where('user_id', auth()->id() ?? 0)
                    ->where(function($q) {
                        $q->where('role', 'author')
                            ->orWhere(function($q) {
                                $q->where('role', '!=', 'author')
                                    ->whereHas('manuscript', function($q) {
                                        $q->where('status', '!=', 'Draft');
                                    });
                            });
                    });
            });
        }
        return $obj;
    }
}
