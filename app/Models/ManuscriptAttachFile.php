<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;

class ManuscriptAttachFile extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'manuscript_attach_files';
    protected static $logAttributes = ["*"];
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

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
        [
            "id" => 13,
            "name" => "Plagiarism Report"
        ]
    ];

    public function manuscript()
    {
        return $this->belongsTo(Manuscript::class, 'manuscript_id', 'id');
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

        if((str_contains(strtolower($mimeType), 'word') || str_contains(strtolower($mimeType), 'pdf')) && $this->type == 1) {

            return true;

        }

        return false;
    }

    /**
     * Get type.
     * 
     * @return Object
     */
    public function getType()
    {
        $types = collect(ManuscriptAttachFile::$types);
        return $types->where('id', $this->type)->first();
    }

    public function storeFile($data)
    {
        if ($data['file'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['file']->storeAs("manuscripts/{$this->manuscript_id}/attach-files/$this->id", $data['file']->getClientOriginalName());
            $this->file_location = $path;
            $this->file_name = $data['file']->getFileName();
            $this->size = Storage::size($path);
            $this->update();
        }
        return $this;
    }

    public function filteredByPermissions($manuscript)
    {
        if ($manuscript->authIsReviewer()) {
            $this->whereIn('type', [1,2]);
        }
        return $this;
    }
}
