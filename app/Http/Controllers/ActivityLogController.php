<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\ActivityLog;
use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    // Require login
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display logs
    public function index()
    {
        // Make sure to define $logs first
        $logs = UserActivityLog::with('user')->latest()->paginate(20);
    
        // Then pass it to the view
        return view('activity_logs.index', compact('logs'));
    }
    
}
