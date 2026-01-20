<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyCode;
use Illuminate\Http\Request;

class AdminDailyCodeController extends Controller
{
    public function index()
    {
        // On récupère les codes du plus récent au plus ancien
        $codes = DailyCode::orderBy('date_day', 'desc')->get();
        return view('admin.codes.index', compact('codes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_day' => 'required|date|unique:daily_codes,date_day',
            'access_code' => 'required|string|max:10',
        ]);

        DailyCode::create($request->all());

        return redirect()->back()->with('success', 'Code enregistré avec succès !');
    }
}
