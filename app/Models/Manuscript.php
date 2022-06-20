<?php

namespace App\Models;

use App\Models\User;
use App\QueryFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Mail\ManuscriptReviewThanksNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manuscript extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'manuscripts';

    protected static $logAttributes = ["*"];
    protected static $logOnlyDirty = true;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'additional_informations' => 'array',
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

    /**
     * Get authors collection
     * @return Collection
     */
    public function authors()
    {
        return $this->hasMany(ManuscriptMember::class, 'manuscript_id', 'id')->where('role', 'author');
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
        if (($this->authIsEditor() || $this->authIsAuthor()) && in_array($input, [$statusList[0]['name'], $statusList[1]['name']])) {

            $this->status = $input;
            $this->update();
            return true;
        
        } elseif($this->authIsReviewer() && in_array($input, [$statusList[2]['name'], $statusList[3]['name'], $statusList[4]['name'], $statusList[5]['name'], $statusList[6]['name']])) {
        
            $this->status = $input;
            $this->update();
            Mail::to(auth()->user()->email)->queue(new ManuscriptReviewThanksNotification($this));
            return true;
        
        } elseif(auth()->user()->can('manuscripts.publish') && in_array($input, [$statusList[7]['name']])) {
        
            $this->status = $input;
            $this->update();
            return true;
        
        }
        
        return false;
    
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
        if (in_array(Auth::user()->id, $this->reviewers->map(function($q){return $q->user_id;})->all() ?? [])) {
            return true;
        }
        return false;
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
}
