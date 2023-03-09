<?php

namespace App\Http\Controllers;

use PDF;
use FPDF;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Manuscript;
use Illuminate\Http\Request;
use App\Mail\ManuscriptCreated;
use App\Models\ManuscriptMember;
use App\Models\ManuscriptComment;
use App\Models\ManuscriptAttachFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ManuscriptAttachCreated;
use App\Mail\ManuscriptAttachUpdated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Models\Filters\ManuscriptFilters;
use App\Http\Resources\ManuscriptResource;
use App\Models\ManuscriptAttachFileComment;
use App\Http\Resources\ManuscriptCollection;
use App\Http\Requests\UpdateManuscriptRequest;
use App\Http\Resources\ManuscriptAttachResource;
use App\Models\Filters\ManuscriptCommentFilters;
use App\Http\Resources\ManuscriptCommentResource;
use App\Http\Resources\ManuscriptAttachCollection;
use App\Http\Resources\ManuscriptCommentCollection;
use App\Http\Requests\UpdateManuscriptStatusRequest;
use App\Http\Resources\ManuscriptAttachFileCommentResource;
use App\Http\Resources\ManuscriptAttachFileCommentCollection;
use \Jurosh\PDFMerge\PDFMerger;

class ManuscriptController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:manuscripts.show', ['only' => ['index', 'show', 'edit']]);
        $this->middleware('permission:manuscripts.edit', ['only' => ['create', 'store', 'update']]);
        $this->middleware('permission:manuscripts.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ManuscriptFilters $manuscriptFilters)
    {   
        $request->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:title,status,updated_at,created_at']
        ]);
        $manuscripts = Manuscript::filter($manuscriptFilters);
        if (!auth()->user()->can('manuscripts.show_all')) {
            $manuscripts->whereHas('members', function($q) {
                $q->where('user_id', auth()->id())
                    ->where('role', 'author');;
            })
                ->orWhereHas('members', function($q) {
                    $q->where('user_id', auth()->id())
                        ->where('role', '!=', 'author')
                        ->whereHas('manuscript', function($q) {
                            $q->where('status', '!=', 'Draft');
                        });
                });
        }
        $manuscripts = new ManuscriptCollection($manuscripts->orderBy('updated_at', 'desc')->paginate(5)->appends(request()->query()));

        if ($request->is('api/*')) {
            return response()->json($manuscripts);
        }
        
        return Inertia::render('Manuscript/Index', [
            'manuscripts' => $manuscripts,
            'manuscriptStatus' => collect(Manuscript::$statusList),
            'filters' => $request->all(['search', 'field', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Manuscript/Create', [
            'articleTypes' => Manuscript::getTypes(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @param Int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function createFinal($id)
    {
        $manuscript = new ManuscriptResource(Manuscript::findOrFail($id));
        return Inertia::render('Manuscript/CreateFinal', [
            'manuscript' => $manuscript,
            'attachTypes' => ManuscriptAttachFile::$types,
            'articleTypes' => Manuscript::getTypes(),
            'manuscriptStatusList' => Manuscript::getStatusList($manuscript->id)
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
        $validated = $request->validate([
            'type' => 'required|numeric',
            'title' => 'required|string',
            'status' => 'nullable|string',
            'authors' => 'required|array',
            'corresponding_authors' => 'array',
            'editors' => 'required|array',
            // 'reviewers' => 'required|array',
        ]);

        $manuscript = Manuscript::create($validated);
        
        if (empty($manuscript)) {
            return abort(400);
        }
        
        ManuscriptMember::createMembers($manuscript, $validated);

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }

        return Redirect::route('manuscript.create.final', [
            'id' => $manuscript->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function storeFinal(Request $request, $id)
    {
        $request->validate([
            'is_confirm_grant_numbers' => 'required|accepted',
            'is_acknowledge' => 'required|accepted'
        ]);
        $manuscript = Manuscript::findOrFail($id);
        $manuscript->status = 'Submit To Editor';

        // Validate submit to editor
        $attachments = $manuscript->attachments->unique('type')->whereIn('type', [1, 5, 13]);
        if ($attachments->count() != 3) {
            // Response error for fail to assign status.
            if ($request->is('api/*')) {
                return response()->json(new ManuscriptResource($manuscript), 401);
            }
            
            return redirect()->back()->withErrors([
                'status' => '"Manuscript", "Cover Letter" and "Plagiarism Report" attached files are required. Please upload the following documents.'
            ]);
        }
        
        $manuscript->additional_informations = [
            'is_confirm_grant_numbers' => $request->is_confirm_grant_numbers == null ? (empty($manuscript->additional_informations['is_confirm_grant_numbers']) ? false : true) : $request->is_confirm_grant_numbers,
            'is_acknowledge' => $request->is_acknowledge == null ? (empty($manuscript->additional_informations['is_acknowledge']) ? false : true) : $request->is_acknowledge
        ];
        $manuscript->update();
        $manuscript->notifyCreateManuscript();

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }

        return Redirect::route('manuscript.edit', [
            'id' => $manuscript->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $manuscript = Manuscript::where('id', $id);

        if (!auth()->user()->can('manuscripts.show_all')) {
            $manuscript->whereHas('members', function($q) {
                $q->where('user_id', auth()->id());
            });
        }
            
        $manuscript = $manuscript->firstOrFail();
        
        $users = User::all();

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }

        return Inertia::render('Manuscript/Show', [
            'manuscript' => new ManuscriptResource($manuscript),
            'attachments' => new ManuscriptAttachCollection($manuscript->attachments()->orderBy('updated_at', 'desc')->paginate(100)),
            'users' => $users,
            'attachTypes' => ManuscriptAttachFile::$types,
            'articleTypes' => Manuscript::getTypes(),
            'manuscriptStatusList' => Manuscript::getStatusList($manuscript->id),
            'manuscriptStatus' => collect(Manuscript::$statusList),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $manuscript = Manuscript::with([
            'authors' => function($q) {
                $q->with('user');
            },
            'correspondingAuthors' => function($q) {
                $q->with('user');
            },
            'editors' => function($q) {
                $q->with('user');
            },
            'reviewers' => function($q) {
                $q->with('user');
            }
        ])
            ->where('id', $id);

        if (!auth()->user()->can('manuscripts.show_all')) {
            $manuscript->whereHas('members', function($q) {
                $q->where('user_id', auth()->id());
            });
        }
            
        $manuscript = $manuscript->firstOrFail();
        
        $users = User::all();

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }

        return Inertia::render('Manuscript/Edit', [
            'manuscript' => new ManuscriptResource($manuscript),
            'attachments' => ManuscriptAttachResource::collection($manuscript->attachments()->orderBy('updated_at', 'desc')->paginate()),
            'filters' => $request->all(['search', 'field', 'direction', 'viewAs']),
            'users' => $users,
            'attachTypes' => ManuscriptAttachFile::$types,
            'articleTypes' => Manuscript::getTypes(),
            'manuscriptStatusList' => Manuscript::getStatusList($manuscript->id),
            'manuscriptStatus' => collect(Manuscript::$statusList),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\StoreManuscriptRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateManuscriptRequest $request, $id)
    {
        $validated = $request->validated();
        $manuscript = Manuscript::where('id', $id);
        if (!auth()->user()->can('manuscripts.show_all')) {
            $manuscript->whereHas('members', function($q) {
                $q->where('user_id', auth()->id());
            });
        }
        $manuscript = $manuscript->firstOrFail();
        $manuscript->update($validated);

        if (
            !empty($validated['authors']) ||
            !empty($validated['corresponding_authors']) ||
            !empty($validated['editor']) ||
            !empty($validated['reviewer'])
        ) {
            ManuscriptMember::syncMembers($manuscript, $validated['authors'], 'author');
            ManuscriptMember::syncMembers($manuscript, $validated['corresponding_authors'], 'corresponding author');
            ManuscriptMember::syncMembers($manuscript, $validated['editors'], 'editor');
        }

        $manuscript->update();

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }

        return Redirect::back();
    }

    /**
     * Update manuscript status controller.
     * @param \App\Http\Requests\UpdateManuscriptStatusRequest $request
     * @param integer $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(UpdateManuscriptStatusRequest $request, $id)
    {
        $manuscript = Manuscript::findOrFail($id);
        // Assign status
        if (!$manuscript->assignStatus($request->status)) {
            // Response error for fail to assign status.
            if ($request->is('api/*')) {
                return response()->json(new ManuscriptResource($manuscript), 401);
            }
            
            return redirect()->back()->withErrors([
                'status' => 'You don\'t have the permission to change manuscript status into "' . $request->status . '".'
            ]);
        }
        
        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $manuscript = Manuscript::findOrFail($id);
        $manuscript->delete();

        if ($request->is('api/*')) {
            return response()->json();
        }

        return Redirect::route('manuscript.index');
    }

    /**
     * Download combined doc in pdf
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, $id)
    {
        $manuscript = Manuscript::findOrFail($id);
        $attachments = ManuscriptAttachFile::where('manuscript_id', $manuscript->id)
            ->get();
        
        // fetch manuscript cover page
        $mainTemplate = view('template.main', [
            'manuscript' => $manuscript,
            'attachFile'  => $attachments->first()
        ])->render();
            
        // Fetch latest manuscript
        $attachment = $attachments->filter(function($value) {
            if ($value->canMerge()) {
                return true;
            }
            return false;
        })?->sortByDesc('id')?->first();
        // Fetch break template
        $breakTemplate = file_get_contents( public_path() . "/break.html" );
        
        if (empty($attachment)) {
            if ($request->is('api/*')) {
                return response('', 403)->json();
            }
            return back()->withErrors([
                'status' => 'There\'s nothing to download.'
            ]);
        }

        // Convert attach file into html
        $attachTemplate = null;
        if (str_contains(Storage::mimeType($attachment->file_location), 'word')) {

            // Convert docs to html.
            $phpWord = \PhpOffice\PhpWord\IOFactory::load(storage_path('app') . '/' . $attachment->file_location);
            $phpWord->setDefaultFontName('times new romen');
            $section = $phpWord->addSection(array('borderColor' => '00FF00', 'borderSize' => 12, 'pageNumberingStart' => 1));

            // Add top label
            $section->addText($attachment->getType()['name']);
            foreach($phpWord->getSections() as $i => $section) {
                $section->setElementIndex($i);
            }

            // sort sections
            $phpWord->sortSections(function($a,$b) { 
                return $a->getElementIndex() < $b->getElementIndex();
            });

            $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            $PDFWriter->save(storage_path('app') . '/' . "{$attachment->file_location}.html");
            
            $attachTemplate = file_get_contents(storage_path('app') . "/{$attachment->file_location}.html" );

            $pdf = PDF::loadHTML($mainTemplate . $breakTemplate . $attachTemplate);
            $pdf->setPaper('A4', 'portrait');
            // $pdf->setOptions(['footer-html', '/resources/views/template/footer.html']);
            return $pdf->stream('merged.pdf');

        } elseif(str_contains(Storage::mimeType($attachment->file_location), 'pdf')) {
            // Create a header for the manuscript
            $pdf = PDF::loadHTML($mainTemplate);
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();
            
            // Save the PDF header template to storage
            $fileName = 'main_template.pdf';
            $filePath = storage_path('app/' . "manuscripts/{$id}/$fileName");
            file_put_contents($filePath, $pdfContent);

            // Create new instance of pdf
            $pdf = new PDFMerger;
            
            // merge the file
            $pdf->addPDF($filePath, 'all', 'vertical')
                ->addPDF(storage_path("app/{$attachment->file_location}"), 'all');
                // ->addPDF('path/to/source/file2.pdf', 'all', 'horizontal');
            // call merge, output format `file`
            return $pdf->merge('browser', str_replace(' ', '-', $manuscript->title . ".pdf"));
        }
        
        if ($request->is('api/*')) {
            return response('', 403)->json();
        }
        return back()->withErrors([
            'status' => 'There\'s nothing to download.'
        ]);
        
    }

    /**
     * 
     */
    public function downloadAttachFile($id, $attachFileId)
    {
        $manuscript = Manuscript::findOrFail($id);
        $attach = ManuscriptAttachFile::findOrFail($attachFileId);
        return Storage::download($attach->file_location);
    }

    /**
     * Index controller for attach file
     * 
     * @param Request $request
     * @param integer $id
     * 
     * @return Response
     */
    public function indexAttachFile(Request $request, $id)
    {
        
    }

    /**
     * Store controller for attach file
     * 
     * @param Request $request
     * @param integer $id
     * 
     * @return Response
     */
    public function storeAttachFile(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'file' => $request->type == 1 ? 'required|mimes:doc,docx' : 'required|mimes:doc,docx,pdf'
        ]);

        $manuscript = Manuscript::findOrFail($id);
        $attach = new ManuscriptAttachFile;   
        $attach->manuscript_id = $id;
        $attach->type = $request->type ?? 1;
        $attach->description = $request->description;
        $attach->size = 0;
        $attach->save();

        if ($request->hasFile('file')) {
            $path = $request->file->store("manuscripts/{$id}/attach-files/$attach->id");
            $attach->file_location = $path;
            $attach->file_name = $attach->getFileName();
            $attach->size = Storage::size($path);
            $attach->update();
        }

        // Send mail
        $manuscript->notifyCreateAttachToMembers($attach);

        // Response
        if ($request->is('api/*')) {
            return response()->json(new ManuscriptAttachCreated($manuscript, $attach));
        }

        if (!empty($request->redirectBack)) {
            return Redirect::route('manuscript.create.final', [
                'id' => $id
            ]);
        }

        return Redirect::route('manuscript.edit', [
            'id' => $manuscript->id
        ]);
        
    }

    /**
     * Show controller for attach file
     * 
     * @param Request $request
     * @param integer $id
     * @param integer $attachFileId
     * 
     * @return Response
     */
    public function showAttachFile(Request $request, $id, $attachFileId)
    {
        
    }

    /**
     * Update controller for attach file
     * 
     * @param Request $request
     * @param integer $id
     * @param integer $attachFileId
     * 
     * @return Response
     */
    public function updateAttachFile(Request $request, $id, $attachFileId)
    {
        $request->validate([
            'type' => 'required',
            'file' => 'required|mimes:doc,docx,pdf'
        ]);

        $manuscript = Manuscript::findOrFail($id);
        $attach = ManuscriptAttachFile::findOrFail($attachFileId);   
        $attach->manuscript_id = $id;
        $attach->type = $request->type ?? $attach->type;
        $attach->description = $request->description ?? $attach->description;
        $attach->update();
        $manuscript->notifyUpdateAttachToMembers($attach);

        if ($request->hasFile('file')) {
            if (Storage::exists($attach->file_location)) {
                Storage::delete($attach->file_location);
            }
            $path = $request->file->store("manuscripts/{$id}/attach-files/$attach->id");
            $attach->file_location = $path;
            $attach->file_name = $attach->getFileName();
            $attach->size = Storage::size($path);
            $attach->update();
        }

        // Response
        if ($request->is('api/*')) {
            return response()->json(new ManuscriptAttachResource($attach));
        }

        return Redirect::route('manuscript.edit', [
            'id' => $manuscript->id
        ]);
    }

    /**
     * Destroy controller for attach file
     * 
     * @param Request $request
     * @param integer $id
     * @param integer $attachFileId
     * 
     * @return Response
     */
    public function destroyAttachFile(Request $request, $id, $attachFileId)
    {
        $manuscript = Manuscript::findOrFail($id);
        $attach = ManuscriptAttachFile::findOrFail($attachFileId)
            ->delete();

        // if (Storage::exists($attach->file_location)) {
        //     Storage::delete($attach->file_location);
        // }
        
        if ($request->is('api/*')) {
            return response()->json();
        }

        return Redirect::back();
    }

    /**
     * Index controller for attach file comments.
     * 
     * @param Request $request
     * @param ManuscriptCommentFilters $filters
     * @param integer $id
     * @param integer $attachFileId
     */
    public function indexComment(Request $request, ManuscriptCommentFilters $filters, $id)
    {
        $comments = ManuscriptComment::filter($filters);
        $comments = $comments->where('manuscript_id', $id);
        $comments = new ManuscriptCommentCollection($comments->get());
        if ($request->is('api/*')) {
            return response()->json($comments);
        }
        return abort(404);
    }

    /**
     * Store controller for attach file comments.
     * 
     * @param Request $request
     * @param integer $id
     */
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'text' => 'required',
            'to' => 'required',
            'from' => ''
        ]);
        $comment = new ManuscriptComment;
        $comment->manuscript_id = $id;
        $comment->user_id = auth()->id();
        $comment->from = $request->from;
        $comment->text = $request->text;
        $comment->to = $request->to ?? 'all';
        $comment->save();
        
        // Send mail
        $comment->notify();

        // Response
        if ($request->is('api/*')) {
            return response()->json(new ManuscriptCommentResource($comment));
        }
        return Redirect::route('manuscript.edit', [
            'id' => $id
        ]);
    }

    /**
     * Index controller for attach file comments.
     * 
     * @param Request $request
     * @param ManuscriptCommentFilters $filters
     * @param integer $id
     * @param integer $attachFileId
     */
    public function indexAttachFileComment(Request $request, ManuscriptCommentFilters $filters, $id, $attachFileId)
    {
        $comments = ManuscriptAttachFileComment::filter($filters);
        $comments = $comments->where('manuscript_attach_id', $attachFileId);
        $comments = new ManuscriptAttachFileCommentCollection($comments->get());
        if ($request->is('api/*')) {
            return response()->json($comments);
        }
        return abort(404);
    }

    /**
     * Store controller for attach file comments.
     * 
     * @param Request $request
     * @param integer $id
     * @param integer $attachFileId
     */
    public function storeAttachFileComment(Request $request, $id, $attachFileId)
    {
        $request->validate([
            'text' => 'required',
            'to' => 'required',
            'from' => ''
        ]);
        $comment = new ManuscriptAttachFileComment;
        $comment->manuscript_attach_id = $attachFileId;
        $comment->user_id = auth()->id();
        $comment->from = $request->from;
        $comment->to = $request->to ?? 'all';
        $comment->text = $request->text;
        $comment->save();
        
        // Send email notification
        $comment->notify();

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptAttachFileCommentResource($comment));
        }
        return Redirect::route('manuscript.edit', [
            'id' => $id
        ]);
    }
}
