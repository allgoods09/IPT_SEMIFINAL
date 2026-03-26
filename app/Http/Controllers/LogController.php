<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $logs = Log::with('user')
            ->when($search, function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            })
            ->latest()
            ->get();

        return view('logs.index', compact('logs', 'search'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'action'=>'required|string',
            'entity_type'=>'required|string',
            'entity_id'=>'required|integer',
            'performed_by'=>'nullable|exists:users,id',
            'description'=>'nullable|string',
        ]);

        return Log::create($data);
    }

    public function show(Log $log)
    {
        return $log->load('user');
    }

    public function destroy(Log $log)
    {
        $log->delete();
        return redirect()->route('logs.index')->with('msg', 'deleted');
        return response()->json(null, 204);
    }
}