<?php

namespace App\Models;

use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Http\Resources\ManuscriptCollection;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\JournalManuscriptCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'journals';

    protected static $logAttributes = ["*"];
    protected static $logOnlyDirty = true;

    protected $casts = [
        'date' => 'datetime'
    ];


    public static $statusList = [
        [
            'name' => 'draft',
            'color' => 'gray'
        ],
        [
            'name' => 'published',
            'color' => 'indigo'
        ],
    ];

    /**
     * The manuscripts that bolong to the journal.
     * 
     * @return Collection
     */
    public function manuscripts()
    {
        return new JournalManuscriptCollection($this->hasMany(JournalManuscript::class, 'journal_id', 'id')->get());
    }

    public function getManuscripts()
    {
        return $this->belongsToMany(Manuscript::class, 'journal_manuscripts', 'journal_id', 'manuscript_id')->where('journal_manuscripts.deleted_at', '=', null);
    }

    /**
     * The manuscripts that bolong to the journal.
     * 
     * @return Collection
     */
    public function rawManuscripts()
    {
        return $this->hasMany(JournalManuscript::class, 'journal_id', 'id');
    }

    public function setManuscripts($manuscript_ids)
    {
        $manuscripts = $this->rawManuscripts;
        if (is_array($manuscript_ids)) {
            foreach ($manuscripts as $manuscript) {
                $m = JournalManuscript::find($manuscript->id);
                if (!empty($m)) {
                    $m->delete();
                }
            }
            foreach ($manuscript_ids as $id) {
                $jManuscript = new JournalManuscript();
                $jManuscript->journal_id = $this->id;
                $jManuscript->manuscript_id = $id;
                $jManuscript->save();
            }
        }
        return $this;
    }

    /**
     * Generate PDF for journal.
     * @param int $manuscript_id
     * 
     * @return String // Generated PDF File Path
     */
    public function generatePDF($manuscript_id = null)
    {
        // Fetch all manuscripts inside journal.
        $manuscripts = $this->getManuscripts()->with([
            'attachments' => function($q) {
                $q->whereIn('type', [1, 14])
                    ->orderBy('updated_at', 'desc');
            }
        ])->get();

        $pdf = new Fpdi();
        $globalPageNumber = 1;
        $docNum = 1;

        foreach ($manuscripts as $key => $manuscript) {

            if ($manuscript->id == $manuscript_id || empty($manuscript_id)) {

                if ($manuscript->id == $manuscript_id) {

                    $docNum = $key + 1;

                }

                $attachment = $manuscript->attachments?->first();
                if (!empty($attachment)) {

                    if ($attachment->canMerge()) {

                        if ($manuscript->isDoc()) {
                            // doc -> html -> pdf
                            return null;
                            // $manuscript->generateHTML();

                        } elseif(!$manuscript->isPDF()) {

                            return null;

                        }
                        
                        $pdf = $manuscript->generatePDF(attachment: $attachment, pdf: $pdf, pageNum: $globalPageNumber++, documentNum: $key + 1, journal: $this);

                    }
                }

            } else {

                $globalPageNumber++;

            }

        }

        $outputPath = empty($manuscript_id) ? public_path("storage/{$this->name}.pdf") : public_path("storage/{$this->name} No {$docNum}.pdf");
        if (empty($pdf)) {

            return null;

        }
        $pdf->Output('F', $outputPath);
        return $outputPath;
    }
}
