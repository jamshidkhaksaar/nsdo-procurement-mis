<?php

namespace App\Http\Controllers;

use App\Exports\AssetExport;
use App\Models\Asset;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportNotificationMail;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

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
        
        // Notify Manager
        $this->notifyManager('Excel Asset Report', $filename);

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

        $filename = 'assets_report_' . date('Y-m-d_H-i') . '.pdf';
        
        // Notify Manager
        $this->notifyManager('PDF Asset Report', $filename);

        $pdf = Pdf::loadView('reports.pdf', compact('assets', 'filters'));
        
        // Optional: Set paper size and orientation
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    protected function notifyManager($type, $filename)
    {
        $user = Auth::user();
        $managers = \App\Models\User::whereIn('role', ['admin', 'manager'])->pluck('email')->toArray();
        
        // Include the user who generated the report
        $recipients = array_unique(array_merge($managers, [$user->email]));

        try {
            Mail::to($recipients)->send(new ReportNotificationMail($user, $type, $filename));
        } catch (\Exception $e) {
            report($e);
        }
    }
}