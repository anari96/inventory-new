<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Teknisi;

use DateInterval;
use DatePeriod;
use DateTime;

class TeknisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // this will default to a time of 00:00:00
        $begin = new DateTime('-1 month');
        $end = new DateTime();
        $periode = [
            $begin->format('d/m/Y'),
            $end->format('d/m/Y'),
        ];

        if(request()->periode){
            $periode = explode(" - ",request()->periode);
            $begin = DateTime::createFromFormat('d/m/Y', $periode[0]);
            $end = DateTime::createFromFormat('d/m/Y', $periode[1]);

        }
        $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        $periodeTanggals = [];
        foreach($daterange as $date) {

            $periodeTanggals[] = strftime("%d-%b", strtotime($date->format("Y-m-d")));
        }

        $datas = Teknisi::whereBetween("created_at", [$begin->format('Y-m-d'), $end->format('Y-m-d')])->paginate(10);

        return response()->view("teknisi.index", compact("datas","periode","periodeTanggals"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view("teknisi.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Teknisi::create([
            "nama_teknisi" => $request->nama_teknisi,
            "telp_teknisi" => $request->telp_teknisi,
        ]);


        return redirect(route("teknisi.index"));
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
        $data = Teknisi::find($id);
        return response()->view("teknisi.edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = Teknisi::find($id);

        $data->update([
            "nama_teknisi" => $request->nama_teknisi,
            "telp_teknisi" => $request->telp_teknisi,
        ]);

        return redirect(route("teknisi.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = Teknisi::find($id);
            $data->delete();
            DB::commit();
            return redirect()->route('teknisi.index')->with('success','Item berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('teknisi.index')->with('error','Item gagal dihapus');
        }
    }
}
