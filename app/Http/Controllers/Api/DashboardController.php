<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Psr7\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryNote\DN_Header;
use App\Models\PurchaseOrder\PO_Header;
use App\Http\Resources\DashboardViewResource;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Laravel\Sanctum\PersonalAccessToken;

class DashboardController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get bp_code by auth
        $sp_code = Auth::user()->bp_code;

        // get data po
        $data_po_active = PO_Header::where('supplier_code', $sp_code)
        ->whereIn('po_status', ['Sent', 'sent'])
        ->count();

        $data_po_in_proccess = PO_Header::where('supplier_code', $sp_code)
        ->whereIn('po_status', ['In Process', 'in process', 'In Progress'])
        ->count();

        // get data dn
        $data_dn_open = DN_Header::where('supplier_code', $sp_code)
        ->whereIn('status_desc', ['Open', 'open'])
        ->count();

        $data_dn_confirmed = DN_Header::where('supplier_code', $sp_code)
        ->whereIn('status_desc', ['Confirmed', 'confirmed'])
        ->count();

        // dd($data_po_in_proccess);

        return response()->json([
            'success' => true,
            'message' => 'Display Dashboard Successfully',
            'data' => [
                'po_active' => $data_po_active,
                'po_in_progress' => $data_po_in_proccess,
                'dn_active' => $data_dn_open,
                'dn_confirmed'=> $data_dn_confirmed
            ]
        ]);
    }

    /**
     * Get the count of active tokens for all roles.
     */
    public function dashboard()
    {
        // Calculate the timestamp for one hour ago
        $oneHourAgo = now()->subHour();

        // Get the count of tokens created within the last hour
        $active_tokens_count = PersonalAccessToken::where('created_at', '>=', $oneHourAgo)
            ->count();

        // Get the total count of users
        $total_users_count = User::count();

        // Get the count of active users where status is 1
        $active_users_count = User::where('status', 1)->count();

        // Get the count of deactive users where status is 0
        $deactive_users_count = User::where('status', 0)->count();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard Data Retrieved Successfully',
            'data' => [
                'active_tokens'   => $active_tokens_count,
                'total_users'     => $total_users_count,
                'active_users'    => $active_users_count,
                'deactive_users'  => $deactive_users_count,
            ]
        ]);
    }
}
