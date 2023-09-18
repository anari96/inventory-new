<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Level::paginate(10);

        $data = [
            "datas" => $datas,
        ];

        return response()->view('level.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level): RedirectResponse
    {
        //
    }
}
