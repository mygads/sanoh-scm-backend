<?php

namespace App\Service\Subcont;

use App\Models\SubcontTransaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SubcontTransactionResource;

class SubcontGetTransaction
{
    public function getAllTransactionSubcont() {
        // Show all subcont transaction data based on authorized user
        $user = Auth::user()->bp_code;

        // Check if user exist
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found'
            ], 404);
        }

        // Get record of subcont transaction data
        $data = SubcontTransaction::whereHas('subItem', function ($q) use ($user) {
            $q->where('bp_code', $user);
        })
            ->orderBy('transaction_date', 'desc')
            ->get();

        // Check if data exist
        if ($data->isEmpty()) {
            // response when empty
            return response()->json([
                'status' => false,
                'message' => 'Subcont Transaction Data Not Found',
                'data' => [],
            ], 200);
        } else {
            // response when success
            return response()->json([
                'status' => true,
                'message' => 'Display List Subcont Transaction Successfully',
                'data' => SubcontTransactionResource::collection($data),
            ], 200);
        }
    }

}
