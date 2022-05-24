<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Manuscript;
use Illuminate\Http\Request;
use App\Mail\ManuscriptCreated;
use App\Mail\ManuscriptUpdated;
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
use App\Http\Resources\ManuscriptAttachResource;
use App\Models\Filters\ManuscriptCommentFilters;
use App\Http\Resources\ManuscriptCommentResource;
use App\Http\Resources\ManuscriptCommentCollection;
use App\Http\Resources\ManuscriptAttachFileCommentResource;
use App\Http\Resources\ManuscriptAttachFileCommentCollection;

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
        $manuscripts = Manuscript::filter($manuscriptFilters);
        
        $manuscripts->where(function($query) {
            $query->whereJsonContains('authors', Auth::user()->id)
                ->orWhereJsonContains('corresponding_authors', Auth::user()->id)
                ->orWhereJsonContains('editors', Auth::user()->id)
                ->orWhereJsonContains('reviewers', Auth::user()->id);
        });

        $manuscripts = new ManuscriptCollection($manuscripts->get());

        if ($request->is('api/*')) {
            return response()->json($manuscripts);
        }

        return Inertia::render('Manuscript/Index', [
            'manuscripts' => $manuscripts
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
            'types' => [
                ['id' => 1, 'name' => 'Full Length Article'],
                ['id' => 2, 'name' => 'Review'],
                ['id' => 3, 'name' => 'Short Communication'],
            ]
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
            'type' => 'required',
        ]);

        $manuscript = new Manuscript();
        $manuscript->type = $request->type;
        $manuscript->corresponding_authors = [
            Auth::user()->id
        ];
        $manuscript->authors = [];
        $manuscript->editors = [];
        $manuscript->reviewers = [];
        $manuscript->publishers = [];
        $manuscript->save();
        $manuscript->generateManuscriptNumber();
        $manuscript->update();
        $coAuthors = collect($manuscript->getCorrespondingAuthors())->map(function($user) {
            return $user['email'];
        });
        Mail::to($coAuthors)->queue(new ManuscriptCreated($manuscript));

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
        $manuscript = Manuscript::findOrFail($id);

        $users = User::all();
        
        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }

        return Inertia::render('Manuscript/Edit', [
            'manuscript' => new ManuscriptResource($manuscript),
            'users' => $users,
            'attachTypes' => ManuscriptAttachFile::$types,
            'articleTypes' => Manuscript::getTypes()
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
        $manuscript = Manuscript::where('id', $id)
            ->where(function($query) {
                $query->whereJsonContains('authors', Auth::user()->id)
                ->orWhereJsonContains('corresponding_authors', Auth::user()->id)
                ->orWhereJsonContains('editors', Auth::user()->id)
                ->orWhereJsonContains('reviewers', Auth::user()->id);
            })
            ->firstOrFail();
        
        $users = User::all();

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }
        
        return Inertia::render('Manuscript/Edit', [
            'manuscript' => new ManuscriptResource($manuscript),
            'users' => $users,
            'attachTypes' => ManuscriptAttachFile::$types,
            'articleTypes' => Manuscript::getTypes(),
            'manuscriptStatusList' => Manuscript::getStatusList($manuscript->id)
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
        $manuscript = Manuscript::where('id', $id)
            ->where(function($query) {
                $query->whereJsonContains('authors', Auth::user()->id)
                ->orWhereJsonContains('corresponding_authors', Auth::user()->id)
                ->orWhereJsonContains('editors', Auth::user()->id)
                ->orWhereJsonContains('reviewers', Auth::user()->id);
            })
            ->firstOrFail();
        $manuscript->type = $request->type;
        $manuscript->editors = $request->editors ?? [];
        $manuscript->reviewers = $request->reviewers ?? [];
        $manuscript->title = $request->title;
        $manuscript->short_title = $request->short_title;
        $manuscript->abstract = $request->abstract;
        // Assign status
        if ($manuscript->status != $request->status) {

            if (!$manuscript->assignStatus($request->status)) {
                // Response error for fail to assign status.
                if ($request->is('api/*')) {
                    return response()->json(new ManuscriptResource($manuscript), 401);
                }
                
                return redirect()->back()->withErrors([
                    'status' => 'You don\'t have the permission to change manuscript status into "' . $request->status . '".'
                ]);
            }

        }
        $manuscript->keywords = $request->keywords;
        $manuscript->authors = $request->authors ?? [];
        $manuscript->corresponding_authors = $request->corresponding_authors ?? [];
        $manuscript->funding_information = $request->funding_information;
        $manuscript->publishers = $request->publishers ?? [];
        $manuscript->additional_informations = [
            'is_confirm_grant_numbers' => $request->is_confirm_grant_numbers ?? false,
            'is_acknowledge' => $request->is_acknowledge ?? false
        ];
        $manuscript->update();

        // Send mail
        $users = collect($manuscript->getCorrespondingAuthors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptUpdated($manuscript));
        }

        $users = collect($manuscript->getAuthors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptUpdated($manuscript));
        }

        $users = collect($manuscript->getEditors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptUpdated($manuscript));
        }

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
        }

        return Redirect::route('manuscript.edit', [
            'id' => $manuscript->id,
        ]);
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

        // Create a main template file to merge with
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save(storage_path('app') . "/manuscripts/{$manuscript->id}/main_template.html");

        // Load main template
        $mainTemp = PDF::loadFile(storage_path('app') . "/manuscripts/{$manuscript->id}/main_template.html")->getDomPDF()->get_dom();
        $break = PDF::loadFile( public_path() . "/break.html" )->getDomPDF()->get_dom();
        // $mainTempBody = $mainTemp->getElementsByTagName('body')->item(0);

        $hasContent = false;

        // Create page for manuscript meta data
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontName('times new romen');
        $section = $phpWord->addSection(array('borderColor' => '00FF00', 'borderSize' => 12, 'marginBottom' => 600));

        // Populate Main meta data
        $section->addText($manuscript->title, array('size' => 20, 'allCaps' => true, 'bold' => true), array('align' => "center", 'space' => array('before' => 0, 'after' => 280), ));
        $section->addText('Author\'s Name:', array('size' => 12, 'allCaps' => false, 'bold' => true), array('align' => "center"));
        $section->addText($manuscript->getAuthors()[0]['name'], array('size' => 12, 'allCaps' => false, 'bold' => false), array('align' => "center"));
        $section->addText('University/Organisation', array('size' => 12, 'allCaps' => false, 'bold' => false), array('align' => "center", 'space' => array('before' => 0, 'after' => 280), ));
        $section->addText('Co-Author\'s Name:', array('size' => 12, 'allCaps' => false, 'bold' => true), array('align' => "center"));
        $section->addText('University/Organisation', array('size' => 12, 'allCaps' => false, 'bold' => false), array('align' => "center", 'space' => array('before' => 0, 'after' => 280), ));

        // Populate Abstract
        $section->addText('Abstract', array('size' => 20, 'allCaps' => true, 'bold' => true), array('align' => "center", 'space' => array('before' => 360, 'after' => 280), ));
        $section->addText($manuscript->abstract, array('size' => 12, 'allCaps' => false, 'bold' => false), array('align' => "left", 'space' => array('before' => 0, 'after' => 280), ));
        $section->addText("Keywords:", array('size' => 12, 'allCaps' => false, 'bold' => true), array('align' => "left"));
        $section->addText($manuscript->keywords, array('size' => 12, 'allCaps' => false, 'bold' => false), array('align' => "left", 'space' => array('before' => 0, 'after' => 280), ));

        // Populate Article type
        $section->addText('Article Type:', array('size' => 12, 'allCaps' => false, 'bold' => true), array('align' => "left"));
        $section->addText($manuscript->getType()['name'], array('size' => 12, 'allCaps' => false, 'bold' => false), array('align' => "left", 'space' => array('before' => 0, 'after' => 280), ));

        // Populate Funding Information
        $section->addText('Funding Information:', array('size' => 12, 'allCaps' => false, 'bold' => true), array('align' => "left"));
        $section->addText($manuscript->funding_information, array('size' => 12, 'allCaps' => false, 'bold' => false), array('align' => "left"));

        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $PDFWriter->save(storage_path('app') . "/manuscripts/{$manuscript->id}/cover_template.html");
        $htmlTemp = PDF::loadFile( storage_path('app') . "/manuscripts/{$manuscript->id}/cover_template.html" )->getDomPDF()->get_dom();
        
        foreach ($htmlTemp->documentElement->childNodes as $child) {
            $import = $mainTemp->importNode($child, true);
            if ($import) {
                $mainTemp->documentElement->appendChild($import);
            }
        }
        
        // break page
        foreach ($break->documentElement->childNodes as $child) {
            $import = $mainTemp->importNode($child, true);
            if ($import) {
                $mainTemp->documentElement->appendChild($import);
            }
        }

        foreach ($attachments as $attachment) {

            // Check for supported file for combine
            if ($attachment->canMerge()) {

                // Create pages for manuscript attachment contains
                if (str_contains(Storage::mimeType($attachment->file_location), 'word')) {

                    // Convert docs to html.
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load(storage_path('app') . '/' . $attachment->file_location);
                    $phpWord->setDefaultFontName('times new romen');
                    $section = $phpWord->addSection(array('borderColor' => '00FF00', 'borderSize' => 12));

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
                }

                // Load html file
                $htmlTemp = PDF::loadFile( storage_path('app') . "/{$attachment->file_location}.html" )->getDomPDF()->get_dom();
                // $htmlBodyTemp = $htmlTemp->getElementsByTagName('body')->item(0);
                // Merge html into one main html temp template
                // foreach ($htmlBodyTemp->childNodes as $child) {
                //     $import = $mainTemp->importNode($child, true);
                //     if ($import) {
                //         $mainTempBody->appendChild($import);
                //     }
                // }

                foreach ($htmlTemp->documentElement->childNodes as $child) {
                    $import = $mainTemp->importNode($child, true);
                    if ($import) {
                        $mainTemp->documentElement->appendChild($import);
                    }
                }

                // break page
                foreach ($break->documentElement->childNodes as $child) {
                    $import = $mainTemp->importNode($child, true);
                    if ($import) {
                        $mainTemp->documentElement->appendChild($import);
                    }
                }

                $hasContent = true;

            }
            
        }

        if ($hasContent) {

            // Save Merged html
            $mainTemp->save(storage_path('app') . "/manuscripts/{$manuscript->id}/final_template.html");
            
            // Download pdf from merged html
            return PDF::loadFile( storage_path('app') . "/manuscripts/{$manuscript->id}/final_template.html" )->stream( 'final_template.pdf' );
        
        }
        
        return PDF::loadFile( storage_path('app') . "/manuscripts/{$manuscript->id}/main_template.html" )->stream( 'final_template.pdf' );
        
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
            'file' => 'required|mimes:doc,docx'
        ]);

        $manuscript = Manuscript::findOrFail($id);
        $attach = new ManuscriptAttachFile;   
        $attach->manuscript_id = $id;
        $attach->type = $request->type ?? "Full Length Article";
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
        $users = collect($manuscript->getCorrespondingAuthors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptAttachCreated($manuscript, $attach));
        }

        $users = collect($manuscript->getAuthors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptAttachCreated($manuscript, $attach));
        }

        $users = collect($manuscript->getEditors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptAttachCreated($manuscript, $attach));
        }

        // Response
        if ($request->is('api/*')) {
            return response()->json(new ManuscriptAttachCreated($manuscript, $attach));
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
            'file' => 'mimes:doc,docx'
        ]);

        $manuscript = Manuscript::findOrFail($id);
        $attach = ManuscriptAttachFile::findOrFail($attachFileId);   
        $attach->manuscript_id = $id;
        $attach->type = $request->type ?? $attach->type;
        $attach->description = $request->description ?? $attach->description;
        $attach->update();

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

        // Send mail
        $users = collect($manuscript->getCorrespondingAuthors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptAttachUpdated($manuscript, $attach));
        }

        $users = collect($manuscript->getAuthors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptAttachUpdated($manuscript, $attach));
        }

        $users = collect($manuscript->getEditors())->map(function($user) {
            return $user['email'];
        });
        if (!empty($users)) {
            Mail::to($users)->queue(new ManuscriptAttachUpdated($manuscript, $attach));
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
        $attach = ManuscriptAttachFile::findOrFail($attachFileId);

        if (Storage::exists($attach->file_location)) {
            Storage::delete($attach->file_location);
        }

        $attach->delete();
        
        if ($request->is('api/*')) {
            return response()->json();
        }

        return Redirect::route('manuscript.edit', [
            'id' => $manuscript->id
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
            'to' => 'required'
        ]);
        $comment = new ManuscriptComment;
        $comment->manuscript_id = $id;
        $comment->user_id = auth()->id();
        $comment->from = $comment->isFrom(auth()->id());
        $comment->text = $request->text;
        $comment->to = $request->to ?? 'all';
        $comment->save();
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
            'to' => 'required'
        ]);
        $comment = new ManuscriptAttachFileComment;
        $comment->manuscript_attach_id = $attachFileId;
        $comment->user_id = auth()->id();
        $comment->from = $comment->isFrom(auth()->id());
        $comment->to = $request->to ?? 'all';
        $comment->text = $request->text;
        $comment->save();
        if ($request->is('api/*')) {
            return response()->json(new ManuscriptAttachFileCommentResource($comment));
        }
        return Redirect::route('manuscript.edit', [
            'id' => $id
        ]);
    }
}
