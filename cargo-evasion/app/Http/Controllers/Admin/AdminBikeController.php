<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bike;
use Illuminate\Http\Request;

class AdminBikeController extends Controller
{
    public function index()
    {
        // On récupère tous les vélos en base de données
        $bikes = Bike::all();
        
        // On les envoie à la vue
        return view('admin.bikes.index', compact('bikes'));
    }
}
