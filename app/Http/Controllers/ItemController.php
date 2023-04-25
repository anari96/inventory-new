<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\KategoriItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Item::where('pengguna_id',Auth::user()->id)->paginate(10);
        return response()->view('item.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {   
        $kategoris = KategoriItem::all();
        $colors = [
            "#F44336",
            "#2196F3",
            "#4CAF50",
            "#FFEB3B",
            "#9C27B0",
            "#FF9800",
            "#795548",
            "#9E9E9E",
        ];
        return response()->view('item.create',compact('kategoris','colors'));
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
    public function show(Item $item): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): RedirectResponse
    {
        //
    }
}
