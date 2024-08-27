<?php

namespace App\Models;

use App\Models\DN_Detail;
use App\Models\PO_Header;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DN_Header extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = "dn_no";

    protected $keyType = 'string';

    public $timestamps = false;

    protected $table = "dn_header";

    protected $fillable = [
        'dn_no',
        'po_no',
        'supplier_code',
        'supplier_name',
        'dn_created_date',
        'dn_year',
        'dn_period',
        'plan_delivery_date',
        'plan_delivery_time',
        'status_desc',
        'confirm_update_at',
        'dn_printed_at',
        'dn_label_printed_at',
    ];

    // Relationship poheader
    public function poHeader(): BelongsTo
    {
        return $this->belongsTo(PO_Header::class, 'po_no', 'po_no');
    }

    // Relationship dndetail
    public function dnDetail(): HasMany
    {
        return $this->hasMany(DN_Detail::class, 'dn_no', 'dn_no');
    }
}
