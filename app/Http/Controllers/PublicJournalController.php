<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Journal;
use App\Models\Manuscript;
use Illuminate\Http\Request;
use App\Http\Resources\JournalResource;
use App\Http\Resources\JournalCollection;
use PDF;

class PublicJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::with([
                'getManuscripts' => function ($q) {
                    $q->with(['getAuthors:id,first_name,last_name', 'getCoAuthors:id,first_name,last_name']);
                },
            ])
            ->where('status', 'Published')
            ->orderBy('date', 'desc')
            ->paginate(request()->input('per_page') ?? 50);

        if (request()->is('api/*')) {
            return response()->json($journals);
        }

        return Inertia::render('Public/Journal/Index', [
            'journals' => $journals,
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
        $journal = Journal::with([
            'getManuscripts' => function ($q) {
                $q->with(['getAuthors:id,first_name,last_name', 'getCoAuthors:id,first_name,last_name']);
            },
        ])->findOrFail($id);
        
        $editorial_board = [
            'publisher' => User::role(['Publisher'])->with('roles')->get(),
            'editor' => User::role(['Editor'])->with('roles')->get(),
            'chief_editor' => User::role(['Chief Editor'])->with('roles')->get(),
        ];

        if (request()->is('api/*')) {
            return response()->json($journal);
        }

        return Inertia::render('Public/Journal/Show', [
            'journal' => $journal,
            'editorial_board' => $editorial_board
        ]);
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

    public function showManuscript(Journal $id, $manuscript_id)
    {
        $manuscript = Manuscript::with(['getAuthors:id,first_name,last_name,affiliation', 'getCoAuthors:id,first_name,last_name,affiliation'])
            ->findOrFail($manuscript_id);

        return Inertia::render('Public/Journal/Manuscripts/Show', [
            'journal' => $id,
            'manuscript' => $manuscript
        ]);
    }

    public function showManuscriptDownload(Request $request, $id, $manuscript_id)
    {

        $journal = Journal::findOrFail($id);

        $outputPath = $journal->generatePDF($manuscript_id);

        if (empty($outputPath)) {
            return abort(403, 'One or more manuscript has an incorrect file format.');
        }

        return response()->download($outputPath)->deleteFileAfterSend(false);

    }

    public function download(Journal $journal)
    {
        
        $journal = Journal::findOrFail($journal?->id);

        $outputPath = $journal->generatePDF();

        if (empty($outputPath)) {
            return abort(403, 'One or more manuscript has an incorrect file format.');
        }

        return response()->download($outputPath)->deleteFileAfterSend(false);
        
    }
}
