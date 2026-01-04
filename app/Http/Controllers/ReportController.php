<?php

namespace App\Http\Controllers;

use App\Exports\AssetExport;
use App\Models\Asset;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('reports.index', compact('projects'));
    }

    public function exportExcel(Request $request)
    {
        $filename = 'assets_report_' . date('Y-m-d_H-i') . '.xlsx';
        return Excel::download(new AssetExport($request->project_id, $request->condition), $filename);
    }

    public function exportPdf(Request $request)
    {
        $query = Asset::with('project');

        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        $assets = $query->get();
        $filters = [
            'project' => $request->project_id ? Project::find($request->project_id)->name : 'All Projects',
            'condition' => $request->condition ?? 'All Conditions',
        ];

        $pdf = Pdf::loadView('reports.pdf', compact('assets', 'filters'));
        
        // Optional: Set paper size and orientation
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('assets_report_' . date('Y-m-d_H-i') . '.pdf');
    }
}