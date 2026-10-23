<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsLog;
use Illuminate\Http\Request;

class SmsLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SmsLog::with('user');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', "%{$request->phone}%");
        }

        $logs = $query->latest()->paginate(20);

        return view('admin.sms.index', compact('logs'));
    }
}
