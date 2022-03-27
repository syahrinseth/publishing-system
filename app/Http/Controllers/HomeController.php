<?php

namespace App\Http\Controllers;

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
        $manuscripts = Manuscript::whereJsonContains('authors', Auth::user()->id)
            ->orWhereJsonContains('corresponding_authors', Auth::user()->id)
            ->orWhereJsonContains('editors', Auth::user()->id)
            ->orWhereJsonContains('reviewers', Auth::user()->id)
            ->get();

        // $manuscript_activities
        $activities = Activity::where('causer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get()->take(10);

        // Next Steps
        $authorNextSteps = Manuscript::whereIn('status', ['Draft', 'Rejected'])
            ->whereJsonContains('authors', Auth::user()->id)
            ->orWhereJsonContains('corresponding_authors', Auth::user()->id)
            ->orWhereJsonContains('editors', Auth::user()->id)
            ->get();
        $reviewerNextSteps = Manuscript::where('status', 'Submit For Review')
            ->whereJsonContains('reviewers', Auth::user()->id)
            ->get();
        $publisherNextSteps = Manuscript::whereIn('status', ['Approved'])
            ->whereJsonContains('publishers', Auth::user()->id)
            ->get();
        
        $total_draft = $manuscripts->where('status', 'Draft')->count();
        $total_review = $manuscripts->where('status', 'Submit For Review')->count();
        $total_rejected = $manuscripts->where('status', 'Rejected')->count();
        $total_approved = $manuscripts->where('status', 'Approved')->count();
        $total_published = $manuscripts->where('status', 'Published')->count();

        return Inertia::render('Home', [
            'manuscript_overview' => [
                'total_draft' => $total_draft,
                'total_review' => $total_review,
                'total_rejected' => $total_rejected,
                'total_approved' => $total_approved,
                'total_published' => $total_published
            ],
            'activities' => new ActivityCollection($activities),
            'nextSteps' => [
                'author' => new ManuscriptCollection($authorNextSteps),
                'reviewer' => new ManuscriptCollection($reviewerNextSteps),
                'publisher' => new ManuscriptCollection($publisherNextSteps)
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
