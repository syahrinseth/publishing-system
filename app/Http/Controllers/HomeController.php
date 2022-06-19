<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Manuscript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\ActivityCollection;
use App\Http\Resources\ManuscriptResource;
use App\Http\Resources\ManuscriptCollection;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('permission:dashboard.show', ['only' => ['index', 'show', 'edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Query Manuscripts
        $manuscripts = Manuscript::query();
        if (!auth()->user()->can('manuscripts.show_all')) {
            $manuscripts->whereHas('members', function($q) {
                $q->where('user_id', auth()->id());
            });
        }
        $manuscripts = $manuscripts->get();

        // Next Steps
        // Author Steps
        $authorNextSteps = Manuscript::whereIn('status', ['Draft', 'Rejected']);
        // if (!auth()->user()->can('manuscripts.show_all')) {
            $authorNextSteps->whereHas('members', function($q) {
                $q->where('user_id', auth()->id())
                    ->whereIn('role', ['author', 'corresponding author']);
            });
        // }
        $authorNextSteps = $authorNextSteps->get();

        // Editor Steps
        $editorNextSteps = Manuscript::whereIn('status', ['Submit To Editor', 'Rejected', 'Rejected Invite To Resubmit', 'Accepted With Minor Changes', 'Accepted With Major Changes']);
        // if (!auth()->user()->can('manuscripts.show_all')) {
            $editorNextSteps->whereHas('members', function($q) {
                $q->where('user_id', auth()->id())
                    ->where('role', 'editor');
            });
        // }
        $editorNextSteps = $editorNextSteps->get();

        // Reviewer Steps
        $reviewerNextSteps = Manuscript::where('status', 'Submit For Review');
        // if (!auth()->user()->can('manuscripts.show_all')) {
            $reviewerNextSteps->whereHas('members', function($q) {
                $q->where('user_id', auth()->id())
                    ->where('role', 'reviewer');
            });
        // }
        $reviewerNextSteps = $reviewerNextSteps->get();

        // Publisher Steps
        $publisherNextSteps = Manuscript::where('status', 'like', '%Accepted%');
        if (!(auth()->user()->can('manuscripts.show_all') && auth()->user()->can('manuscripts.publish'))) {
            $publisherNextSteps->whereHas('members', function($q) {
                $q->where('user_id', auth()->id())
                    ->where('role', 'publisher');
            });
        }
        $publisherNextSteps = $publisherNextSteps->get();
        
        // Filter Manuscript Status card
        $total_draft = $manuscripts->where('status', 'Draft')->count();
        $total_draft_link = http_build_query([ 'ids' => $manuscripts->where('status', 'Draft')->map(function($manuscript) {return $manuscript->id;})->all()]);

        $total_submit_to_editor = $manuscripts->where('status', 'Submit To Editor')->count();
        $total_submit_to_editor_link = http_build_query([ 'ids' => $manuscripts->where('status', 'Submit To Editor')->map(function($manuscript) {return $manuscript->id;})->all()]);

        $total_review = $manuscripts->where('status', 'Submit For Review')->count();
        $total_review_link = http_build_query([ 'ids' => $manuscripts->where('status', 'Submit For Review')->map(function($manuscript) {return $manuscript->id;})->all()]);

        $total_rejected = $manuscripts->whereIn('status', ['Rejected', 'Rejected Invite To Resubmit', ])->count();
        $total_rejected_link = http_build_query([ 'ids' => $manuscripts->whereIn('status', ['Rejected', 'Rejected Invite To Resubmit', ])->map(function($manuscript) {return $manuscript->id;})->all()]);

        $total_approved = $manuscripts->whereIn('status', ['Accepted Without Changes', 'Accepted With Minor Changes', 'Accepted With Major Changes'])->count();
        $total_approved_link = http_build_query([ 'ids' => $manuscripts->whereIn('status', ['Accepted Without Changes', 'Accepted With Minor Changes', 'Accepted With Major Changes'])->map(function($manuscript) {return $manuscript->id;})->all()]);

        $total_published = $manuscripts->where('status', 'Published')->count();
        $total_published_link = http_build_query([ 'ids' => $manuscripts->where('status', 'Published')->map(function($manuscript) {return $manuscript->id;})->all()]);

        $total_reviewers_reviewed_manuscripts = User::getTotalReviewersReviewedManuscripts();

        return Inertia::render('Home', [
            'manuscript_overview' => [
                'total_draft' => $total_draft,
                'total_draft_link' => $total_draft_link,
                'total_submit_to_editor' => $total_submit_to_editor,
                'total_submit_to_editor_link' => $total_submit_to_editor_link,
                'total_review' => $total_review,
                'total_review_link' => $total_review_link,
                'total_rejected' => $total_rejected,
                'total_rejected_link' => $total_rejected_link,
                'total_approved' => $total_approved,
                'total_approved_link' => $total_approved_link,
                'total_published' => $total_published,
                'total_published_link' => $total_published_link,
                'total_reviewers_reviewed_manuscripts' => $total_reviewers_reviewed_manuscripts
            ],
            'nextSteps' => [
                'author' => new ManuscriptCollection($authorNextSteps),
                'reviewer' => new ManuscriptCollection($reviewerNextSteps),
                'publisher' => new ManuscriptCollection($publisherNextSteps),
                'editor' => new ManuscriptCollection($editorNextSteps)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
