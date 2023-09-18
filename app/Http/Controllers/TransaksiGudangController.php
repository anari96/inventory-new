<?php

namespace App\Http\Controllers;

use App\Models\TransaksiGudang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransaksiGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = TransaksiGudang::paginate(10);

        $data = [
            'datas' => $datas,
        ];

        return response()->view('transaksi_gudang.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $data = [
        ];

        return response()->view('transaksi_gudang.create', $data);
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
    public function show(TransaksiGudang $transaksiGudang): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiGudang $transaksiGudang): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiGudang $transaksiGudang): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiGudang $transaksiGudang): RedirectResponse
    {
        //
    }
}
