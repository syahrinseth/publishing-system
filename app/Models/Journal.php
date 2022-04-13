<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Http\Resources\ManuscriptCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'journals';

    protected static $logAttributes = ["*"];
    protected static $logOnlyDirty = true;

    /**
     * The arrtibutes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'manuscripts' => 'array'
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
        $ids_ordered = implode(',', $this->manuscripts ?? []);
        $manuscripts = Manuscript::whereIn('id', $this->manuscripts ?? []);
        if ($ids_ordered != null) {
            $manuscripts->orderByRaw("FIELD(id, $ids_ordered)");
        }
        return new ManuscriptCollection($manuscripts->get());
    }
}
