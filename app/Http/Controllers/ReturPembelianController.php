<?php

namespace App\Http\Controllers;

use App\Models\ReturPembelian;
use App\Models\DetailReturPembelian;
use App\Models\Item;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReturPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = ReturPembelian::paginate(10);
        $data = [
            'datas' => $datas
        ];

        return response()->view("retur_pembelian.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $data = [
        ];
        return response()->view("retur_pembelian.create", $data);
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
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }
}
