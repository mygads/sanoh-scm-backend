<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PODetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'bp_part_no' => $this->bp_part_no,
            'item_desc_a' => $this->item_desc_a,
            'purchase_unit' => $this->purchase_unit,
            'po_qty' => $this->po_qty,
        ];
    }
}