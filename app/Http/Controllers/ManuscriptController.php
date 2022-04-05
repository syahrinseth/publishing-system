<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Manuscript;
use Illuminate\Http\Request;
use App\Models\ManuscriptAttachFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ManuscriptResource;
use App\Http\Resources\ManuscriptCollection;
use App\Http\Resources\ManuscriptAttachResource;

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
    public function index(Request $request)
    {   
        $manuscripts = Manuscript::whereJsonContains('authors', Auth::user()->id)
            ->orWhereJsonContains('corresponding_authors', Auth::user()->id)
            ->orWhereJsonContains('editors', Auth::user()->id)
            ->orWhereJsonContains('reviewers', Auth::user()->id)
            ->get();
        $manuscripts = new ManuscriptCollection($manuscripts);

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
        $manuscript->authors = [
            Auth::user()->id
        ];
        $manuscript->corresponding_authors = [];
        $manuscript->editors = [];
        $manuscript->reviewers = [];
        $manuscript->publishers = [];
        $manuscript->save();

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
        $manuscript->editors = $request->editors == null ? [] : [$request->editors];
        $manuscript->reviewers = $request->reviewers == null ? [] : [$request->reviewers];
        $manuscript->title = $request->title;
        $manuscript->short_title = $request->short_title;
        $manuscript->abstract = $request->abstract;
        // Assign status
        if (!$manuscript->assignStatus($request->status) && $manuscript->status != $request->status) {

            // Response error for fail to assign status.
            if ($request->is('api/*')) {
                return response()->json(new ManuscriptResource($manuscript), 401);
            }
            
            return redirect()->back()->withErrors([
                'status' => 'You don\'t have the permission to change manuscript status into "' . $request->status . '".'
            ]);

        }
        $manuscript->keywords = $request->keywords;
        $manuscript->authors = $request->authors;
        $manuscript->funding_information = $request->funding_information;
        $manuscript->publishers = $request->publishers == null ? [] : [$request->publishers];
        $manuscript->additional_informations = [
            'is_confirm_grant_numbers' => $request->is_confirm_grant_numbers ?? false,
            'is_acknowledge' => $request->is_acknowledge ?? false
        ];
        $manuscript->update();

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
    public function downloadAttachFile(Request $request, $id, $attachFileId)
    {
        $manuscript = Manuscript::findOrFail($id);
        $attach = ManuscriptAttachFile::findOrFail($attachFileId);
        return Storage::download($attach->file_location);
        // \PhpOffice\PhpWord\Settings::setPdfRendererPath($file_path);
        // \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
    
        // //Load word file
        $Content = \PhpOffice\PhpWord\IOFactory::load($file_path . '/test.docx');

        // //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'HTML');
        $PDFWriter->save("{$file_path}/test2.html");

        $doc1 = PDF::loadFile( "{$file_path}/test.html" )->getDomPDF()->get_dom();
        $doc2 = PDF::loadFile( "{$file_path}/test2.html" )->getDomPDF()->get_dom();
        $doc3 = PDF::loadFile( "{$file_path}/test3.html" )->getDomPDF()->get_dom();
        $break = PDF::loadFile( public_path() . "/break.html" )->getDomPDF()->get_dom();

        $doc1Body = $doc1->getElementsByTagName('body')->item(0);
        $doc2Body = $doc2->getElementsByTagName('body')->item(0);
        $doc3Body = $doc3->getElementsByTagName('body')->item(0);
        $breakBody = $break->getElementsByTagName('body')->item(0);
        foreach ($doc2Body->childNodes as $child) {
            $import = $doc1->importNode($child, true);
            if ($import) {
                $doc1Body->appendChild($import);
            }
        }
        
        foreach ($breakBody->childNodes as $child) {
            $import = $doc1->importNode($child, true);
            if ($import) {
                $doc1Body->appendChild($import);
            }
        }

        foreach ($doc3Body->childNodes as $child) {
            $import = $doc1->importNode($child, true);
            if ($import) {
                $doc1Body->appendChild($import);
            }
        }
            
        // foreach ($doc2Body->childNodes as $child) {
        //     // dump($child);
        //     $import = $doc1->importNode($child, true);
        //     if ($import) {
        //         $doc1->appendChild($import);
        //     }
        // }
        $doc1->save("{$file_path}/final.html");
        return PDF::loadFile( "{$file_path}/final.html" )->stream( 'download.pdf' );
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

        if ($request->is('api/*')) {
            return response()->json(new ManuscriptResource($manuscript));
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
}
