<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use OwenIt\Auditing\Models\Audit;

class AuditLogController extends Controller
{
    public function index()
    {
        $audits = Audit::with(['user', 'auditable'])->latest()->paginate(20);
        return view('admin.audits.index', compact('audits'));
    }
}