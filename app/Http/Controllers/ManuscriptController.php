<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use PDF;

class ManuscriptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'id' => 1,
            'name' => 'Manuscript 1',
            'Desc' => 'Test Desc'
        ];
        return Inertia::render('Manuscript/Index', $data);
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
        $data = [
            'id' => 1,
            'name' => 'Manuscript 1',
            'Desc' => 'Test Desc'
        ];

        return response()->json($data);
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
        $data = [
            'id' => 1,
            'name' => 'Manuscript 1',
            'Desc' => 'Test Desc'
        ];
        return Inertia::render('Manuscript/Edit', $data);
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
}
