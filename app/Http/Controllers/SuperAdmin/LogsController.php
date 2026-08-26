<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(Request $request)
    {
        $logs = Log::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('user_name', 'like', '%' . $search . '%')
                        ->orWhere('user_email', 'like', '%' . $search . '%')
                        ->orWhere('action', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filled('module'), function ($query) use ($request) {
                $query->where('module', $request->input('module'));
            })
            ->orderByDesc('action_time')
            ->paginate(20)
            ->withQueryString();

        $modules = Log::query()->distinct()->orderBy('module')->pluck('module');

        return view('logs.index', [
            'logs' => $logs,
            'modules' => $modules,
        ]);
    }
}
