<?php

namespace App\Models;

use App\Models\User;
use App\QueryFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
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
        'authors' => 'array',
        'corresponding_authors' => 'array',
        'editors' => 'array',
        'reviewers' => 'array',
        'publishers' => 'array',
        'additional_informations' => 'array'
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
            'name' => "Accept Without Changes",
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
        ]
    ];

    /**
     * Get authors collection
     * @return array
     */
    public function getAuthors()
    {
        $users = User::whereIn('id', $this->authors ?? [])
            ->get();
        return $users->toArray();
    }

    /**
     * Get corresponding authors collection
     * @return array
     */
    public function getCorrespondingAuthors()
    {
        $users = User::whereIn('id', $this->corresponding_authors ?? [])
            ->get();
        return $users->toArray();
    }

    /**
     * Get editors collection
     * @return array
     */
    public function getEditors()
    {
        $users = User::whereIn('id', $this->editors ?? [])
            ->get();
        return $users->toArray();
    }

    /**
     * Get reviewers collection
     * @return array
     */
    public function getReviewers()
    {
        $users = User::whereIn('id', $this->reviewers ?? [])
            ->get();
        return $users->toArray();
    }

    /**
     * Get publishers collection
     * @return array
     */
    public function getPublishers()
    {
        $users = User::whereIn('id', $this->publishers ?? [])
            ->get();
        return $users->toArray();
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
            return true;
        
        } elseif($this->authIsPublisher() && in_array($input, [$statusList[7]['name']])) {
        
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
        if (in_array(Auth::user()->id, $this->authors ?? [])) {
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
        if (in_array(Auth::user()->id, $this->editors ?? [])) {
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
        if (in_array(Auth::user()->id, $this->reviewers ?? [])) {
            return true;
        }
        return false;
    }

    /**
     * Validate if auth is publisher of the manuscript.
     * @return boolean
     */
    public function authIsPublisher()
    {
        if (in_array(Auth::user()->id, $this->publishers ?? [])) {
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
        if (Manuscript::where('id', $this->id)->whereJsonContains('authors', auth()->id())->exists()){
            $tempRole = 'author';
        } else if(Manuscript::where('id', $this->id)->whereJsonContains('corresponding_authors', auth()->id())->exists()) {
            $tempRole = 'corresponding author';
        } else if(Manuscript::where('id', $this->id)->whereJsonContains('reviewers', auth()->id())) {
            $tempRole = 'reviewer';
        } else if (Manuscript::where('id', $this->id)->whereJsonContains('editors', auth()->id())) {
            $tempRole = 'editor';
        } else if (Manuscript::where('id', $this->id)->whereJsonContains('publishers', auth()->id())) {
            $tempRole = 'publisher';
        }
        return $tempRole;
    }
}
