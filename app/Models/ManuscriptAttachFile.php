<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ManuscriptAttachFile extends Model
{
    use HasFactory;

    protected $table = 'manuscript_attach_files';

    /**
     * 
     */
    public function saveDocxAsHtml()
    {
        $file_path = Storage::path("manuscripts/{$this->manuscript_id}/attach-files/{$this->id}");

        \PhpOffice\PhpWord\Settings::setPdfRendererPath($file_path);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
    
        //Load word file
        $Content = \PhpOffice\PhpWord\IOFactory::load("{$file_path}/{$this->file_name}");

        //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'HTML');
        $PDFWriter->save("{$file_path}/${$this->file_name}.html"); 
        return $this;
    }

    /**
     * 
     */
    public function hasFile()
    {
        return Storage::exists("manuscripts/{$this->manuscript_id}/attach-files/{$this->id}/{$this->file_name}");
    }

    /**
     * 
     */
    public function getFileExt()
    {
        $path = Storage::exists("manuscripts/{$this->manuscript_id}/attach-files/{$this->id}/{$this->file_name}");
        return pathinfo($path, PATHINFO_EXTENSION);
    }

}
