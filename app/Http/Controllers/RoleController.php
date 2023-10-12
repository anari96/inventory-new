<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Menu;
use App\Helpers\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Role::paginate(10);

        $data = [
            "datas" => $datas,
        ];

        return response()->view('role.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $menus = Menu::all();
        $menu_model = new Menu;
        $menu_lists = Menu::select("nama_menu")->groupBy('nama_menu')->get();

        $data = [
           "menus" => $menus,
           "menu_lists" => $menu_lists,
           "menu_model" => $menu_model,
        ];
        return response()->view('role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try{
            $role = Role::create([
                'nama_role' => $request->nama_role
            ]);

            if ($request->menu_id == NULL) {
                return redirect()->back()->with('error', 'Minimal Pilih satu menu');
            }

            if($role){
                $role->menu()->attach($request->menu_id);
            }


            DB::commit();
            return redirect()->route('role.index')->with('success', "Role Berhasil ditambah" );
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('role.create')->with('error', $th->getMessage() );
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
        $datas = Role::find($id);
        $menus = Menu::all();
        $menu_model = new Menu;
        $menu_lists = Menu::select("nama_menu")->groupBy('nama_menu')->get();

        $data = [
            "id" => $id,
            "datas" => $datas,
            "menus" => $menus,
            "menu_lists" => $menu_lists,
            "menu_model" => $menu_model,
        ];
        return response()->view('role.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try{
            $role = Role::find($id);
            $old = $role->toArray();

            if ($request->menu_id == NULL) {
                return redirect()->back()->with('error', 'Minimal Pilih satu menu');
            }

            $role->update([
               "nama_role" => $request->nama_role,
            ]);

            $role->menu()->sync([]);
            $role->menu()->attach($request->menu_id);

            DB::commit();
            return redirect()->route('role.index')->with('success', "Role Berhasil ditambah" );
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('role.create')->with('error', $th->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $role = Role::find($id);
            $permission = Permission::where("role_id",  $id);

            $role->delete();
            $permission->delete();

            DB::commit();
            return redirect()->route('role.index')->with('success','Role berhasil ditambah');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('role.index')->with('error', "Role gagal dihapus");
        }
    }
}
