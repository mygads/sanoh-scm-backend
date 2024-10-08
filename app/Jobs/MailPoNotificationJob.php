<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\PO_Header;
use App\Mail\PoResponseSupplier;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MailPoNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get data User
        $user = User::where('role', 1)->get(['bp_code','email']);

        // Get PO open based of bp_code
        foreach ($user as $data) {

            $po_header = PO_Header::with('user')
            ->where('supplier_code', $data->bp_code)
            ->whereIn('po_status', ['Sent','Open'])
            ->get();

            // Store/format the return value of po_header into collection map function
            $collection = $po_header->map(function ($data) {
                $user = $data->user;

                return [
                    'bp_code' => $user ? $user->bp_code : 'User Data Not Found',
                    'email' => $user ? $user->email : 'Data Email Data Not Found',
                    'po_no' => $data->po_no
                ];
            });

            Mail::to($data->email)->send(new PoResponseSupplier( po_header: $collection));
        }
    }
}
