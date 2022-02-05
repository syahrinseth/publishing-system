<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ManuscriptAttachFile extends Model
{
    use HasFactory;

    protected $table = 'manuscript_attach_files';

    public static $types = [
        [
            "id" => 1,
            "name" => "Manuscript"
        ],
        [
            "id" => 2,
            "name" => "Highlights (for review)"
        ],
        [
            "id" => 3,
            "name" => "Declaration of Interest Statement"
        ],
        [
            "id" => 4,
            "name" => "Conflict of Interest"
        ],
        [
            "id" => 5,
            "name" => "Cover Letter"
        ],
        [
            "id" => 6,
            "name" => "Figure(s)"
        ],
        [
            "id" => 7,
            "name" => "Table(s)"
        ],
        [
            "id" => 8,
            "name" => "CRediT Author Statement"
        ],
        [
            "id" => 9,
            "name" => "Supplementary Material"
        ],
        [
            "id" => 10,
            "name" => "Response to Reviewers"
        ],
        [
            "id" => 11,
            "name" => "Video Still"
        ],
        [
            "id" => 12,
            "name" => "LaTeX Source Files"
        ],
    ];

    public function manuscript()
    {
        return $this->hasOne(Manuscript::class, 'id');
    }

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
        $PDFWriter->save("{$file_path}/{$this->file_name}.html"); 
        return $this;
    }

    /**
     * 
     */
    public function hasFile()
    {
        return Storage::exists($this->file_location);
    }

    /**
     * 
     */
    public function getFileExt()
    {
        $path = Storage::exists($this->file_location);
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Get File Name
     * 
     */
    public function getFileName()
    {
        return basename($this->file_location);
    }

    /**
     * Check if attachment can be merge
     * 
     * @return boolean
     */
    public function canMerge()
    {
        $mimeType = Storage::mimeType($this->file_location);

        if (
            str_contains(strtolower($mimeType), 'image') || 
            str_contains(strtolower($mimeType), 'pdf')
        ) {

            return false;

        } else if(!str_contains(strtolower($mimeType), 'word')) {

            return false;

        }

        return true;
    }
}
