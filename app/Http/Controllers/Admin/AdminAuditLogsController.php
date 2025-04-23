<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
# Audit log model
use App\Models\AuditLog;
use App\Http\Controllers\Controller;


class AdminAuditLogsController extends Controller
{
    //
    public function logs()
    {
        // Fetch audit logs from the database
       // $auditLogs = AuditLog::all();
        $logs = AuditLog::orderBy('created_at', 'desc')
            ->select('*')
            ->get();
                    // Return the view with the audit logs
        return view('admin.auditlog',compact('logs'));
    }
}
