<?php

namespace App\Http\Controllers\Api;

use App\Models\DN_Header;
use App\Models\PO_Header;
use App\Http\Resources\DN_HistoryViewResource;
use App\Http\Resources\PO_HistoryViewResource;
use GuzzleHttp\Psr7\Header;

class HistoryController
{
    // this controller is for get the data that needed for history
    // PO History
    public function poHeaderHistory($bp_code)
    {
        // $user = Auth::user();
        // $tes = (string) $bp_code;
        // dd($tes);
        //get data api to view
        $data_po = PO_Header::with('partner','poDetail')
                            ->where('supplier_code', $bp_code)
                            ->whereIn('po_status', ['Closed','closed','close','Cancelled','cancelled','cancel'])
                            ->get();

        // dd($data_po);
        return response()->json([
            'success' => true,
            'message' => 'Display List PO History Successfully',
            'data' => PO_HistoryViewResource::collection($data_po)
        ]);
    }

    // DN History
    public function dnHeaderHistory($bp_code)
    {
        // $code = $bp_code;
        //get data api to view
        $data_dn = DN_Header::with('poHeader','dnDetail')
        ->where('supplier_code', $bp_code)
        ->orderBy('plan_delivery_date', 'desc')
        ->whereIn('status_desc', ['Closed','closed','close','Confirmed','confirmed'])
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Display List DN History Successfully',
            'data' => DN_HistoryViewResource::collection($data_dn)
        ]);
    }
}
