<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Manuscript;
use Illuminate\Http\Request;
use App\Models\ManuscriptAttachFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ManuscriptResource;
use App\Http\Resources\ManuscriptCollection;

class ManuscriptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manuscripts = new ManuscriptCollection(Manuscript::all());
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
        $manuscript->authors = [];
        $manuscript->corresponding_authors = [];
        $manuscript->editors = [];
        $manuscript->reviewers = [];
        $manuscript->save();

        return response()->json($manuscript);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manuscript = Manuscript::findOrFail($id);
        $users = User::all();
        return Inertia::render('Manuscript/Edit', [
            'manuscript' => new ManuscriptResource($manuscript),
            'users' => $users,
            'attachTypes' => ManuscriptAttachFile::$types
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

    /**
     * 
     */
    public function downloadManuscriptAttach(Request $request, $manuscript_id, $id)
    {
        $file_path = Storage::path('manuscripts/1/attach-files/1');
        // \PhpOffice\PhpWord\Settings::setPdfRendererPath($file_path);
        // \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
    
        // //Load word file
        // $Content = \PhpOffice\PhpWord\IOFactory::load($file_path . '/test.docx');

        // //Save it into PDF
        // $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'HTML');
        // $PDFWriter->save("{$file_path}/test2.html"); 
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
     * Get Manuscript Types
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function indexManuscriptTypes(Request $request)
    {
        $data = [
            ['id' => 1, 'name' => 'Full Length Article'],
            ['id' => 2, 'name' => 'Review'],
            ['id' => 3, 'name' => 'Short Communication'],
        ];

        return response()->json($data);
    }

    /**
     * Index controller for attach file
     * 
     * @param Request $request
     * @param integer $id
     * 
     * @return Response
     */
    public function indexAttachFiles(Request $request, $id)
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
    public function storeAttachFiles(Request $request, $id)
    {
        $manuscript = Manuscript::findOrFail($id);
        $users = User::all();
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
        return Inertia::render('Manuscript/Edit', [
            'manuscript' => new ManuscriptResource($manuscript),
            'users' => $users,
            'attachTypes' => ManuscriptAttachFile::$types
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
    public function showAttachFiles(Request $request, $id, $attachFileId)
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
    public function updateAttachFiles(Request $request, $id, $attachFileId)
    {
        $manuscript = Manuscript::findOrFail($id);
        $users = User::all();
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
        return Inertia::render('Manuscript/Edit', [
            'manuscript' => new ManuscriptResource($manuscript),
            'users' => $users,
            'attachTypes' => ManuscriptAttachFile::$types
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
    public function destroyAttachFiles(Request $request, $id, $attachFileId)
    {
        $manuscript = Manuscript::findOrFail($id);
        $users = User::all();
        $attach = ManuscriptAttachFile::findOrFail($attachFileId);
        if (Storage::exists($attach->file_location)) {
            Storage::delete($attach->file_location);
        }
        $attach->delete();
        return Inertia::render('Manuscript/Edit', [
            'manuscript' => new ManuscriptResource($manuscript),
            'users' => $users,
            'attachTypes' => ManuscriptAttachFile::$types
        ]);
    }
}
