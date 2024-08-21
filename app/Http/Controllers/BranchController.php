<?php 

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Role;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\BusinessType;
use DataTables;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Branch::with('businessType')
                ->when(auth()->user()->role_id != 1, function ($query) {
                    return $query->where('user_id', auth()->id());
                })
                ->get();

            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button class="edit btn btn-primary btn-sm" data-id="'.$row->id.'">Editar</button> ';
                    $btn .= '<button class="manage-employees btn btn-info btn-sm" data-id="'.$row->id.'"> Administrar Empleados</button> ';
                    $btn .= '<button class="delete btn btn-dark btn-sm" data-id="'.$row->id.'">Eliminar</button>';
                    return $btn;
                })
                ->editColumn('active', function($row) {
                    return $row->active 
                        ? '<span class="badge bg-success">Activo</span>' 
                        : '<span class="badge bg-danger">Inactivo</span>';
                })
                ->rawColumns(['action','active'])
                ->make(true);
        }

        $business_types = BusinessType::whereNotIn('id', [1, 2])->get();
        return view('admin.branches.index', compact('business_types'));
    }

    public function getEmployees($branchId)
    {
        
        if (request()->ajax()) {
            $employees = Employee::with('role') // Asumiendo que Employee tiene una relación con Role
                ->where('branch_id', $branchId)
                ->get();

            return DataTables::of($employees)
                ->addColumn('action', function($row){
                    $btn = '<button class="editEmploye btn btn-primary btn-sm" data-id="'.$row->id.'">Editar</button> ';
                    $btn .= '<button class="deleteEmploye btn btn-dark btn-sm" data-id="'.$row->id.'">Eliminar</button>';
                    return $btn;
                })
                ->editColumn('active', function($row) {
                    return $row->active 
                        ? '<span class="badge bg-success">Activo</span>' 
                        : '<span class="badge bg-danger">Inactivo</span>';
                })
                ->rawColumns(['action', 'active'])
                ->make(true);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'business_type_id' => 'required|exists:business_types,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|string|email|max:255',
            'active' => 'required|boolean',
        ]);

        // Bloquear la inserción y modificación para business_type_id 1 y 2
        if (in_array($request->business_type_id, [1, 2]) && auth()->user()->role_id != 1) {
            return response()->json(['message' => 'No se permite crear o modificar sucursales para los tipos de negocio seleccionados.'], 403);
        }

        $data = $request->only(['name', 'address', 'phone', 'email', 'active']);

        try {
            if ($request->id) {
                $branch = Branch::where('id', $request->id);

                if (auth()->user()->role_id != 1) {
                    $branch = $branch->where('user_id', auth()->id())->firstOrFail();
                } else {
                    $branch = $branch->firstOrFail();
                }

                $data['business_type_id'] = $branch->business_type_id;
            } else {
                if (auth()->user()->role_id != 1) {
                    $data['user_id'] = auth()->id();
                }
                $data['business_type_id'] = $request->business_type_id;
            }

            $branch = Branch::updateOrCreate(
                ['id' => $request->id],
                $data
            );

            return response()->json(['message' => 'Sucursal guardada exitosamente.', 'branch' => $branch]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar la sucursal. Por favor, inténtalo de nuevo.'], 500);
        }
    }

    

    public function editEmployee($id)
    {
        // Buscar al empleado por su ID, incluyendo la relación con la sucursal
        $employee = Employee::with('branch')->findOrFail($id);
        // Devolver ambos conjuntos de datos en formato JSON
        return response()->json([
            'employee' => $employee
        ]);
        
    }

    public function getRoles($id)
    {
        // Obtener la sucursal con el tipo de negocio, filtrando según el rol del usuario
        $business_type_id = Branch::with('businessType')
                    ->where('id',$id)
                    ->when(auth()->user()->role_id != 1, function ($query) {
                        return $query->where('user_id', auth()->id());
                    })
                    ->where('business_type_id','>',2)
                    ->first()->business_type_id; // Filtrar por la sucursal del empleado

        $role = Role::where('business_type_id',$business_type_id)
                ->get();
        // Devolver respuesta de datos en formato JSON
        return response()->json($role);
    }

    public function getBranches()
    {
        // Obtener la sucursal con el tipo de negocio, filtrando según el rol del usuario
        $branch = Branch::with('businessType')
                    ->when(auth()->user()->role_id != 1, function ($query) {
                        return $query->where('user_id', auth()->id());
                    })
                    ->get(); // Filtrar por la sucursal del empleado
        // Devolver ambos conjuntos de datos en formato JSON
        return response()->json($branch);
    }

    public function edit($id)
    {
        try {
            $branch = Branch::query();

            if (auth()->user()->role_id != 1) {
                $branch->where('user_id', auth()->id());
            }

            $branch = $branch->findOrFail($id);
            return response()->json($branch);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al cargar la sucursal. Por favor, inténtalo de nuevo.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $branch = Branch::query();

            if (auth()->user()->role_id != 1) {
                $branch->where('user_id', auth()->id());
            }
            $branch = $branch->findOrFail($id);
            $branch->update(['active' => 0]);

            return response()->json(['message' => 'Sucursal eliminada exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la sucursal. Por favor, inténtalo de nuevo.'], 500);
        }
    }
}
