<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Journal;
use Illuminate\Http\Request;
use App\Http\Resources\JournalResource;
use App\Http\Resources\JournalCollection;

class PublicJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::where('status', 'Published')
            ->orderBy('date', 'desc')
            ->paginate(request()->input('per_page') ?? 50);
        $journals = new JournalCollection($journals);

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
        $journal = Journal::findOrFail($id);
        $journal = new JournalResource($journal);
        $manuscripts = $journal->manuscripts();
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
            'manuscripts' => $manuscripts,
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
}
