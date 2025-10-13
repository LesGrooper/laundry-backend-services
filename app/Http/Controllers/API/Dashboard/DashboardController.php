<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    // public function index(Request $request) {
    //     return $this->calendar($request);
    // }
    /**
     * Endpoint untuk ambil data invoice untuk kalender/dashboard
     * GET /api/dashboard/calendar
     */
    public function calendar(Request $request)
    {
        $invoices = DB::table('invoice as i')
            ->leftJoin('customers as c', 'i.invoice_owner_id', '=', 'c.id')
            ->leftJoin('service_products as s', 'i.service_products_id', '=', 's.id')
            ->select(
                'i.id as invoice_id',
                'c.customers_name as customer_name',
                's.service_products_name',
                'i.created_at as date_in',
                'i.invoice_deadline as deadline',
                'i.invoice_status as status'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $invoices
        ]);
    }

    public function reportSummary()
    {
        $totalCustomers = DB::table('customers')->count();
        $totalInvoices = DB::table('invoice')->count();
        $invoicesPending = DB::table('invoice')->where('invoice_status', 'pending')->count();
        $invoicesDone = DB::table('invoice')->where('invoice_status', 'done')->count();

        return response()->json([
            'success' => true,
            'data' => [
                [
                    'title' => 'Total Customers',
                    'number' => $totalCustomers,
                    'icon' => 'feather icon-users text-c-blue',
                    'design' => 'border-bottom'
                ],
                [
                    'title' => 'Total Invoices',
                    'number' => $totalInvoices,
                    'icon' => 'feather icon-file-text text-c-purple',
                    'design' => 'border-bottom'
                ],
                [
                    'title' => 'Pending Invoices',
                    'number' => $invoicesPending,
                    'icon' => 'feather icon-clock text-c-yellow',
                    'design' => 'border-bottom'
                ],
                [
                    'title' => 'Completed Invoices',
                    'number' => $invoicesDone,
                    'icon' => 'feather icon-check-circle text-c-green',
                    'design' => 'border-bottom'
                ],
            ]
        ]);
    }
}
