<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalManuscript;
use Illuminate\Support\Facades\Redirect;

class JournalManuscriptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'manuscripts' => 'array|required'
        ]);
        
        foreach ($validated['manuscripts'] as $manuscript_id) {
            JournalManuscript::create([
                'journal_id' => $id,
                'manuscript_id' => $manuscript_id
            ]);
        }

        if (request()->is('api/*')) {
            return response()->json();
        }

        return Redirect::route('journal.edit', [
            'id' => $id
        ]);
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
     * @param  int  $manuscript_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $manuscript_id)
    {
        $journal_manuscript = JournalManuscript::where('manuscript_id', $manuscript_id)
            ->where('journal_id', $id)
            ->firstOrFail()
            ->delete();

        if (request()->is('api/*')) {
            return response()->json();
        }

        return Redirect::route('journal.edit', [
            'id' => $id
        ]);
    }
}
