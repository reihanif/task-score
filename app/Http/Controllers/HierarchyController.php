<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class HierarchyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::orderBy('level', 'asc')->get();

        return view('app.positions.hierarchy', [
            'positions' => $positions,
        ]);
    }
}
