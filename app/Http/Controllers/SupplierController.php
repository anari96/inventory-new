<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

use DateInterval;
use DatePeriod;
use DateTime;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $datas = Supplier::paginate(10);

        return response()->view("supplier.index", compact('datas',"periodeTanggals"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view("supplier.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            Supplier::create([
                "nama_supplier" => $request->nama_supplier,
                "telp_supplier" => $request->telp_supplier,
                "alamat" => $request->alamat,
            ]);

            DB::commit();
            return redirect()->route("supplier.index")->with('success','data berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('supplier.index')->with('error', $th);
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
        $data = Supplier::find($id);
        return response()->view("supplier.edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = Supplier::find($id);
        DB::beginTransaction();
        try {
            $data->update([
                "nama_supplier" => $request->nama_supplier,
                "telp_supplier" => $request->telp_supplier,
                "alamat" => $request->alamat,
            ]);

            DB::commit();
            return redirect()->route("supplier.index")->with('success','data berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('supplier.index')->with('error', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = Supplier::find($id);
            $data->delete();
            DB::commit();
            return redirect()->route('supplier.index')->with('success','Item berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('supplier.index')->with('error','Item gagal dihapus');
        }
    }
}
