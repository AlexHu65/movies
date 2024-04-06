<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    protected $section = 'movies';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'section' => $this->section,
            'action' => __FUNCTION__
        ];

        return view('dashboard.dataTables.index', $data);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'section' => $this->section,
            'action' => __FUNCTION__
        ];

        return view('dashboard.forms.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'section' => $this->section,
            'action' => __FUNCTION__
        ];

        return view('dashboard.forms.index', $data);
    }

    
}
