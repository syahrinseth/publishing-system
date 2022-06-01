<?php

namespace App\Models;

use Exception;
use App\QueryFilter;
use App\Models\Manuscript;
use Illuminate\Support\Facades\Mail;
use App\Mail\ManuscriptCommentCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManuscriptComment extends Model
{
    use HasFactory;

    protected $table = 'manuscript_comments';

    /**
     * The attachments that belong to the manuscript.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the manuscript that owns the comment.
     */
    public function manuscript()
    {
        return $this->belongsTo(Manuscript::class, 'manuscript_id', 'id');
    }

    /**
     * Scoped Filter method.
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**
     * @return String
     * 
     */
    public function isFrom()
    {
        $manuscript = Manuscript::find($this->manuscript_id);
        return $manuscript == null ? 'unknown' : $manuscript->findUserRole($this->user_id);
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
            $manuscript = Manuscript::where('id', $this->manuscript_id)->firstOrFail();
            if ($this->to == "all") {
                $authors = collect($manuscript->getAuthors())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($authors);
                
                $co_authors = collect($manuscript->getCorrespondingAuthors())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($co_authors);

                $editors = collect($manuscript->getEditors())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($editors);

                $reviewers = collect($manuscript->getReviewers())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($reviewers);

                $publishers = collect($manuscript->getPublishers())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($publishers);

            } elseif($this->to == "authors") {

                $authors = collect($manuscript->getAuthors())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($authors);

                $co_authors = collect($manuscript->getCorrespondingAuthors())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($co_authors);

            } elseif($this->to == "reviewers") {

                $reviewers = collect($manuscript->getReviewers())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($reviewers);

            } elseif($this->to == "editors") {

                $editors = collect($manuscript->getEditors())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($editors);

            } elseif($this->to == "publishers") {

                $publishers = collect($manuscript->getPublishers())->map(function($user){
                    return $user['email'];
                });
                $emails = $emails->merge($publishers);
            }
            if ($emails->count() > 0) {
                Mail::to($emails)->queue(new ManuscriptCommentCreated($this));
                return true;
            }
            return false;
        } catch(Exception $e) {
            return false;
        }
    }
}
