<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Http\Resources\ManuscriptCollection;
use App\Http\Resources\JournalManuscriptCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'journals';

    protected static $logAttributes = ["*"];
    protected static $logOnlyDirty = true;


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
}
