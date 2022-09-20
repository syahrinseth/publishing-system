<?php

namespace App\Models;

use Exception;
use App\Models\User;
use App\QueryFilter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use App\Mail\ManuscriptAttachCommentCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManuscriptAttachFileComment extends Model
{
    use HasFactory;

    protected $table = 'manuscript_attach_file_comments';

    public function attachFile()
    {
        return $this->hasOne(ManuscriptAttachFile::class, 'id');    
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Scoped Filter method.
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**
     * @param int $user_id
     * @return String
     * 
     */
    public function isFrom($user_id)
    {
        $manuscriptAttach = ManuscriptAttachFile::find($this->manuscript_attach_id);
        if (!empty($manuscriptAttach)) {
            $manuscript = Manuscript::find($manuscriptAttach->manuscript_id);
            return $manuscript == null ? 'unknown' : $manuscript->findUserRole($user_id);
        }
        return 'unknown';
    }

    /**
     * @param App\Mail\ManuscriptCommentCreated | App\Mail\ManuscriptCommentUpdated
     * 
     * @return boolean
     */
    public function notify()
    {
        try {
            // Get user emails
            $emails = collect();
            $attach_file = $this->attachFile;
            $manuscript = $attach_file->manuscript;

            if ($this->to == "all") {

                $members = $manuscript->members->map(function($member){
                    return $member->user->email;
                });
                $emails = $emails->merge($members);

                $publishers = User::whereHas('roles', function($q){$q->whereIn('name', ['Super Admin', 'Admin', 'Publisher']);})->get()->map(function($member){
                    return $member->user->email;
                });
                $emails = $emails->merge($publishers);

            } elseif($this->to == "authors") {

                $authors = $manuscript->authors->map(function($member){
                    return $member->user->email;
                });
                $emails = $emails->merge($authors);

                $co_authors = $manuscript->correspondingAuthors->map(function($member){
                    return $member->user->email;
                });
                $emails = $emails->merge($co_authors);

            } elseif($this->to == "reviewers") {

                $reviewers = $manuscript->reviewers->map(function($member){
                    return $member->user->email;
                });
                $emails = $emails->merge($reviewers);

            } elseif($this->to == "editors") {

                $editors = $manuscript->editors->map(function($member){
                    return $member->user->email;
                });
                $emails = $emails->merge($editors);

            } elseif($this->to == "publishers") {

                $publishers = User::whereHas('roles', function($q){$q->whereIn('name', ['Super Admin', 'Admin', 'Publisher']);})->get()->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($publishers);

            }
            if ($emails->count() > 0) {
                
                Mail::to($emails)->queue(new ManuscriptAttachCommentCreated($this));
                return true;
                
            }
            return false;
        } catch(Exception $e) {dd($manuscript);
            return false;
        }
    }
}