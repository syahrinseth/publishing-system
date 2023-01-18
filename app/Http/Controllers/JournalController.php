<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\JournalResource;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\JournalCollection;
use App\Http\Resources\JournalManuscriptCollection;

class JournalController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:journals.show', ['only' => ['index', 'show', 'edit']]);
        $this->middleware('permission:journals.edit', ['only' => ['create', 'store', 'update']]);
        $this->middleware('permission:journals.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::query();

        if (!auth()->user()->can('journals.show_all')) {
            $journals->where('user_id', Auth::user()->id);
        }
            
        $journals = $journals->orderBy('updated_at', 'desc')
            ->paginate(5);
        $journals = new JournalCollection($journals);

        if (request()->is('api/*')) {
            return response()->json($journals);
        }

        return Inertia::render('Journal/Index', [
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
        return Inertia::render('Journal/Create', [
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'status' => '',
            'manuscripts' => '',
            'user_id' => '',
            'description' => 'nullable'
        ]);

        $journal = new Journal();
        $journal->name = $request->name;
        $journal->setManuscripts($request->manuscripts);
        $journal->date = $request->date;
        $journal->status = $request->status ?? 'draft';
        $journal->user_id = Auth::user()->id;
        $journal->description = $request->description;
        $journal->save();

        if ($request->is('api/*')) {
            return response()->json(new JournalResource($journal));
        }

        return Redirect::route('journal.edit', [
            'id' => $journal->id
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
        $journal = Journal::findOrFail($id);
        $journal = new JournalResource($journal);

        if (request()->is('api/*')) {
            return response()->json($journal);
        }

        return Inertia::render('Journal/Edit', [
            'journal' => $journal
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
        $journal = Journal::findOrFail($id);
        $journal = new JournalResource($journal);

        if (request()->is('api/*')) {
            return response()->json($journal);
        }

        return Inertia::render('Journal/Edit', [
            'journal' => $journal
        ]);
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
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'description' => 'nullable'
        ]);
        $journal = Journal::findOrfail($id);
        $journal->name = $request->name;
        $journal->date = $request->date;
        $journal->status = $request->status;
        $journal->description = $request->description;
        $journal->update();

        if ($request->is('api/*')) {
            return response()->json(new JournalResource($journal));
        }

        return Redirect::route('journal.edit', [
            'id' => $journal->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        $journal->delete();

        if (request()->is('api/*')) {
            return response()->json();
        }

        return Redirect::route('journal.index');
    }

    public function indexManuscript(Request $request, $id)
    {
        $journal = Journal::findOrFail($id);
        $manuscripts = $journal->rawManuscripts;
        if ($request->is('api/*')) {
            return response()->json(new JournalManuscriptCollection($manuscripts));
        }
        return abort(404);
    }
}
