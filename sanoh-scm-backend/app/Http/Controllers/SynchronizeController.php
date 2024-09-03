<?php

namespace App\Http\Controllers;

// model sql server
use Carbon\Carbon;
use App\Models\Partner;
use App\Models\DN_Detail;
use App\Models\DN_Header;
use App\Models\PO_Detail;

// model mysql
use App\Models\PO_Header;
use App\Models\PartnerLocal;
use Illuminate\Http\Request;
use App\Models\DN_Detail_ERP;
use App\Models\DN_Header_ERP;

use App\Models\PO_Detail_ERP;
use App\Models\PO_Header_ERP;

class SynchronizeController extends Controller
{
    // Copy data ERP bussiness_partner
    // function for copy the data from sql server to mysql
    public function copyBusinessPartner()
    {
        // get all data from sql server
        $sqlsrvData = Partner::All();

        // copy all data from sql server
        foreach ($sqlsrvData as $data) {
            PartnerLocal::updateOrCreate([
                'bp_code' => $data->bp_code,
                'bp_name' => $data->bp_name,
                'bp_status_desc' => $data->bp_status_desc,
                'bp_currency' => $data->bp_currency,
                'country' => $data->country,
                'adr_line_1' => $data->adr_line_1,
                'adr_line_2' => $data->adr_line_2,
                'adr_line_3' => $data->adr_line_3,
                'adr_line_4' => $data->adr_line_4,
                'bp_phone' => $data->bp_phone,
                'bp_fax' => $data->bp_fax,
            ]);
        }

        return response()->json(['message' => 'Data business_partner successfuly copied']);
    }

    // Copy data ERP po_header
    // function for copy the data from sql server to mysql
    public function copyPoHeader()
    {
        // get all data from sql server
        $sqlsrvData = PO_Header_ERP::where('po_period', 8)
            ->where('po_year', 2024)
            ->get();

        // copy all data from sql server
        foreach ($sqlsrvData as $data) {
            PO_Header::updateOrCreate([
                'po_no' => $data->po_no,
                'supplier_code' => $data->supplier_code,
                'supplier_name' => $data->supplier_name,
                'po_date' => $data->po_date,
                'po_year' => $data->po_year,
                'po_period' => $data->po_period,
                'po_status' => $data->po_status,
                'reference_1' => $data->reference_1,
                'reference_2' => $data->reference_2,
                'attn_name' => $data->attn_name,
                'po_currency' => $data->po_currency,
                'po_type_desc' => $data->po_type_desc,
                'pr_no' => $data->pr_no,
                'planned_receipt_date' => $data->planned_receipt_date,
                'payment_term' => $data->payment_term,
                'po_origin' => $data->po_origin,
                'po_revision_no' => $data->po_revision_no,
                'po_revision_date' => $data->po_revision_date,
                'response' => $data->response,
            ]);
        }

        return response()->json(['message' => 'Data po_header successfuly copied']);
    }

    // Copy data ERP bussiness_partner
    // function for copy the data from sql server to mysql
    public function copyPoDetail()
    {
        // get all data from sql server
        $sqlsrvData = PO_Detail_ERP::where('po_period', 8)
            ->where('po_year', 2024)
            ->get();

        // copy all data from sql server
        foreach ($sqlsrvData as $data) {
            PO_Detail::updateOrCreate([
                'po_no' => $data->po_no,
                'po_line' => $data->po_line,
                'po_sequence' => $data->po_sequence,
                'item_code' => $data->item_code,
                'code_item_type' => $data->code_item_type,
                'bp_part_no' => $data->bp_part_no,
                'bp_part_name' => $data->bp_part_name,
                'item_desc_a' => $data->item_desc_a,
                'item_desc_b' => $data->item_desc_b,
                'planned_receipt_date' => $data->planned_receipt_date,
                'po_qty' => $data->po_qty,
                'receipt_qty' => $data->receipt_qty,
                'invoice_qty' => $data->invoice_qty,
                'purchase_unit' => $data->purchase_unit,
                'price' => $data->price,
                'amount' => $data->amount,
            ]);
        }

        return response()->json(['message' => 'Data po_detail successfuly copied']);
    }

    // Copy data ERP bussiness_partner
    // function for copy the data from sql server to mysql
    public function copyDnHeader()
    {
        $sqlsrvData = DN_Header_ERP::where('dn_period', 8)
            ->where('dn_year', 2024)
            ->get();


        // copy all data from sql server
        foreach ($sqlsrvData as $data) {
            // get all data from sql server
            if (empty($data->no_dn)) {
                continue;
            }

            DN_Header::updateOrCreate([
                'no_dn' => $data->no_dn,
                'po_no' => $data->po_no,
                'supplier_code' => $data->supplier_code,
                'supplier_name' => $data->supplier_name,
                'dn_created_date' => $data->dn_create_date,
                'dn_year' => $data->dn_year,
                'dn_period' => $data->dn_period,
                'plan_delivery_date' => $data->plan_delivery_date,
                'plan_delivery_time' => $data->plan_delivery_time,
                'status_desc' => $data->status_desc,
            ]);
        }

        return response()->json(['message' => 'Data dn_header successfuly copied']);
    }

    // Copy data ERP bussiness_partner
    // function for copy the data from sql server to mysql
    public function copyDnDetail()
    {
        // get all data from sql server
        $sqlsrvData = DN_Detail_ERP::where('dn_year', 2024)
            ->get();


        // copy all data from sql server
        foreach ($sqlsrvData as $data) {
            DN_Detail::updateOrCreate([
                'no_dn' => $data->no_dn,
                'dn_line' => $data->dn_line,
                'order_origin' => $data->order_origin,
                'plan_delivery_date' => $data->plan_delivery_date,
                'plan_delivery_time' => $data->plan_delivery_time,
                'actual_receipt_date' => $data->actual_receipt_date,
                'actual_receipt_time' => $data->actual_receipt_time,
                'order_set' => $data->order_set,
                'order_line' => $data->order_line,
                'order_seq' => $data->order_seq,
                'part_no' => $data->part_no,
                'supplier_item_no' => $data->supplier_item_no,
                'item_desc_a' => $data->item_desc_a,
                'item_desc_b' => $data->item_desc_b,
                'lot_number' => $data->lot_number,
                'dn_qty' => $data->dn_qty,
                'receipt_qty' => $data->receipt_qty,
                'dn_unit' => $data->dn_unit,
                'dn_snp' => $data->dn_snp,
                'reference' => $data->reference,
                'status_desc' => $data->status_desc,
            ]);
        }

        return response()->json(['message' => 'Data dn_detail successfuly copied']);
    }

    public function sync()
    {
        /*


                partner



        */
        // get data
        $sqlsrvDataPartner = Partner::All();

        // copy all data from sql server
        foreach ($sqlsrvDataPartner as $data) {
            PartnerLocal::updateOrCreate(
                // find the bp_code
                ['bp_code' => $data->bp_code],
                //update data
                [
                    'bp_name' => $data->bp_name,
                    'bp_status_desc' => $data->bp_status_desc,
                    'bp_currency' => $data->bp_currency,
                    'country' => $data->contry,
                    'adr_line_1' => $data->adr_line_1,
                    'adr_line_2' => $data->adr_line_2,
                    'adr_line_3' => $data->adr_line_3,
                    'adr_line_4' => $data->adr_line_4,
                    'bp_phone' => $data->bp_phone,
                    'bp_fax' => $data->bp_fax,
                ]
            );
        }

        /*

                po header



        */
        //year and period
        $actualYear = Carbon::now()->year;
        $actualPeriod = Carbon::now()->month;
        // dd($actualYear,$actualPeriod);

        $sqlsrvDataPoHeader = PO_Header_ERP::where('po_period', $actualPeriod)
            ->where('po_year', $actualYear)
            ->get();


        // copy all data from sql server
        $passPoNo = [];
        foreach ($sqlsrvDataPoHeader as $data) {
            $passPoNo[] = $data->po_no;

            PO_Header::updateOrCreate(
                // find the po_no
                [
                    'po_no' => $data->po_no,
                    'supplier_code' => $data->supplier_code
                ],
                // update data
                [
                    'supplier_name' => $data->supplier_name,
                    'po_date' => $data->po_date,
                    'po_year' => $data->po_year,
                    'po_period' => $data->po_period,
                    'po_status' => $data->po_status,
                    'reference_1' => $data->reference_1,
                    'reference_2' => $data->reference_2,
                    'attn_name' => $data->attn_name,
                    'po_currency' => $data->po_currency,
                    'po_type_desc' => $data->po_type_desc,
                    'pr_no' => $data->pr_no,
                    'planned_receipt_date' => $data->planned_receipt_date,
                    'payment_term' => $data->payment_term,
                    'po_origin' => $data->po_origin,
                    'po_revision_no' => $data->po_revision_no,
                    'po_revision_date' => $data->po_revision_date,
                    'response' => $data->response,
                ]
            );
        }

        /*

                po detail


        */
        foreach ($passPoNo as $data) {
            $sqlsrvDataPoDetail = PO_Detail_ERP::where('po_no', $data)->get();

            // copy all data from sql server
            foreach ($sqlsrvDataPoDetail as $data) {
                PO_Detail::updateOrCreate(
                    [
                        'po_no' => $data->po_no,
                        'po_line' => $data->po_line
                    ],
                    [
                        'po_sequence' => $data->po_sequence,
                        'item_code' => $data->item_code,
                        'code_item_type' => $data->code_item_type,
                        'bp_part_no' => $data->bp_part_no,
                        'bp_part_name' => $data->bp_part_name,
                        'item_desc_a' => $data->item_desc_a,
                        'item_desc_b' => $data->item_desc_b,
                        'planned_receipt_date' => $data->planned_receipt_date,
                        'po_qty' => $data->po_qty,
                        'receipt_qty' => $data->receipt_qty,
                        'invoice_qty' => $data->invoice_qty,
                        'purchase_unit' => $data->purchase_unit,
                        'price' => $data->price,
                        'amount' => $data->amount,
                    ]
                );
            }
        }

        /*

                dn header



        */
        $passDnNo = [];
        foreach ($passPoNo as $data) {
            $sqlsrvDataDnHeader = DN_Header_ERP::where('po_no', $data)->get();
            // copy all data from sql server
            foreach ($sqlsrvDataDnHeader as $data) {
                $passDnNo[] = $data->no_dn;

                DN_Header::updateOrCreate(
                    [
                        'no_dn' => $data->no_dn,
                        'po_no' => $data->po_no
                    ],
                    [
                        'supplier_code' => $data->supplier_code,
                        'supplier_name' => $data->supplier_name,
                        'dn_created_date' => $data->dn_create_date,
                        'dn_year' => $data->dn_year,
                        'dn_period' => $data->dn_period,
                        'plan_delivery_date' => $data->plan_delivery_date,
                        'plan_delivery_time' => $data->plan_delivery_time,
                        'status_desc' => $data->status_desc,
                    ]
                );
            }
        }

        /*


                dn detail


        */
        foreach ($passDnNo as $data) {
            $sqlsrvDataDnDetail = DN_Detail_ERP::where('no_dn', $data)->get();
            // copy all data from sql server
            foreach ($sqlsrvDataDnDetail as $data) {
                DN_Detail::updateOrCreate(
                    [
                        'no_dn' => $data->no_dn,
                        'dn_line' => $data->dn_line
                    ],
                    [
                        'order_origin' => $data->order_origin,
                        'plan_delivery_date' => $data->plan_delivery_date,
                        'plan_delivery_time' => $data->plan_delivery_time,
                        'actual_receipt_date' => $data->actual_receipt_date,
                        'actual_receipt_time' => $data->actual_receipt_time,
                        'no_order' => $data->no_order,
                        'order_set' => $data->order_set,
                        'order_line' => $data->order_line,
                        'order_seq' => $data->order_seq,
                        'part_no' => $data->part_no,
                        'supplier_item_no' => $data->supplier_item_no,
                        'item_desc_a' => $data->item_desc_a,
                        'item_desc_b' => $data->item_desc_b,
                        'lot_number' => $data->lot_number,
                        'dn_qty' => $data->dn_qty,
                        'receipt_qty' => $data->receipt_qty,
                        'dn_unit' => $data->dn_unit,
                        'dn_snp' => $data->dn_snp,
                        'reference' => $data->reference,
                        'status_desc' => $data->status_desc,
                    ]
                );
            }
        }

        return response()->json(['message' => 'Data successfuly Sync']);
    }
}
