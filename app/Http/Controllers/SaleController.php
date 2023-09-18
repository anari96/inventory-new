<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Sale::paginate(10);

        $data=[
            "datas" => $datas,
        ];

        return response()->view('sale.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('sale.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
        $request->validate([
            "nama_sales" => "required",
            "alamat" => "required",
            "kontak" => "required",
        ]);
            Sale::create([
                "nama_sales" => $request->nama_sales,
                "alamat" => $request->alamat,
                "kontak" => $request->kontak,
            ]);

            DB::commit();
            return redirect()->route('sale.index')->with('success','Sales berhasil ditambah');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('sale.create')->with('error', $th->getMessage() );
        }

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
        $datas = Sale::find($id);
        $data = [
            "datas" => $datas,
        ];

        return response()->view("sale.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $sale = Sale::find($id);
            $request->validate([
                "nama_sales" => "required",
                "alamat" => "required",
                "kontak" => "required",
            ]);
            $sale->update([
                "nama_sales" => $request->nama_sales,
                "alamat" => $request->alamat,
                "kontak" => $request->kontak,
            ]);

            DB::commit();
            return redirect()->route('sale.index')->with('success','Sales berhasil ditambah');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('sale.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $sale = Sale::find($id);

            $sale->delete();

            DB::commit();
            return redirect()->route('sale.index')->with('success','Sales berhasil ditambah');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('sale.index')->with('error', "Sales gagal dihapus");
        }
    }
}
