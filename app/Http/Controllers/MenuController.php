<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $menus = Menu::all();
            return DataTables::of($menus)
                ->addColumn('roles', function ($menu) {
                    $roles = json_decode($menu->roles, true);
                    $roleNames = Role::with('businessType')->whereIn('id', $roles)->get()->map(function($role) {
                                    return $role->businessType->name . ' - ' . $role->name;
                                })->toArray();
                    return implode('<br> ', $roleNames);
                })
                ->addColumn('status', function ($menu) {
                    return $menu->status ? 'Activo' : 'Inactivo';
                })

                ->addColumn('action', function ($menu) {
                    return '<button class="editMenu btn btn-primary btn-sm" data-id="' . $menu->id . '">Editar</button>
                            <button class="deleteMenu btn btn-dark btn-sm" data-id="' . $menu->id . '">Eliminar</button>';
                })
                ->rawColumns(['action','icon','roles'])
                ->make(true);
        }

        $roles = Role::with('businessType')->get();
        return view('admin.menus.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_name' => 'required|string',
            'sub_menu_name' => 'nullable|string',
            'subsub_menu_name' => 'nullable|string',
            'route' => 'required|string',
            'status' => 'required|boolean',
            'roles' => 'nullable|array',
            'order' => 'nullable|integer',
        ]);

        $roles = $request->input('roles', []);
        $menuData = $request->only(['menu_name', 'sub_menu_name', 'subsub_menu_name', 'route', 'status', 'order','icon']);
        $menuData['roles'] = json_encode($roles);

        if ($request->input('menu_id')) {
            $menu = Menu::find($request->input('menu_id'));
            if ($menu) {
                $menu->update($menuData);
            }
        } else {
            Menu::create($menuData);
        }

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        $roles = Role::all();
        return response()->json(['menu' => $menu, 'roles' => $roles]);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            $menu->delete();
        }
        return response()->json(['success' => true]);
    }
}
