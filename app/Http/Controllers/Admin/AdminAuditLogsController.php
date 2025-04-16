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

        // Return the view with the audit logs
        return view('admin.auditlog');
    }
}
