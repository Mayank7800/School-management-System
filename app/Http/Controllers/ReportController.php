<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function export($table)
    {
        // ✅ Check if table exists
       if (!DB::getSchemaBuilder()->hasTable($table)) {
            return redirect()->back()->with('error', 'Invalid table selected!');
        }

        $fileName = $table . '_report_' . now()->format('Y_m_d_H_i_s') . '.csv';

        // ✅ Stream CSV output to browser
        $response = new StreamedResponse(function () use ($table) {
            $handle = fopen('php://output', 'w');

            // Fetch data
            $data = DB::table($table)->get();

            if ($data->isEmpty()) {
                fputcsv($handle, ['No data found']);
            } else {
                // Add header row
                fputcsv($handle, array_keys((array) $data->first()));

                // Add all rows
                foreach ($data as $row) {
                    fputcsv($handle, (array) $row);
                }
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }

     public function index()
    {
        return view('reports');
    }
}
