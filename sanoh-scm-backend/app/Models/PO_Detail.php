<?php

namespace App\Models;

use App\Models\PO_Header;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PO_Detail extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = "po_detail_no";

    public $timestamps = false;

    protected $table = "po_detail";

    // Relationship belongs to po header
    public function poHeader(): BelongsTo
    {
        return $this->belongsTo(PO_Header::class, 'po_no', 'po_no');
    }

}
