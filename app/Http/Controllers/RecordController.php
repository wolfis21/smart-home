<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Record;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $query = Record::where('users_id', auth()->id());

        if ($request->filled('type')) {
            $type = $request->input('type');
    
            switch ($type) {
                case 'dispositivo':
                    $query->where('event', 'like', '%Dispositivo%');
                    break;
                case 'alerta':
                    $query->where('event', 'like', '%Alerta%');
                    break;
                case 'sesion':
                    $query->where('event', 'like', '%sesión%');
                    break;
            }
        }
    
        $records = $query->orderBy('date_event', 'desc')->paginate(10);
    
        return view('records.index', compact('records'));
    }
}
