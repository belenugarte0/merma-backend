<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Permission\PermissionResource;
use App\Http\Resources\Permission\FullPermissionResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return new PermissionCollection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        // VALIDAR DATOS
        $permission = $request->validated();
        // GUARDAR EL REQUEST VALIDADO
        Permission::create( $permission );


        // RETORNAR MENSAJE DE GUARDADO 
        return response()->json([
            "message" => "La Usuario fue registrada",
            "permission" => $permission
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();

        $data['roles'] = $role;
        $data['permissions'] = $rolePermissions;

        return $this->sendResponse($data, 'Success', 200);
    }

            

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::find($id);

        if( !$permission )
        {
            return response()->json([
                "message" => "No se encontro la Usuario",
            ], 404);
        }
        $request->validate([
            'email' => 'required|email|unique:permissions,email,' . $permission->id,
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'document' => 'required|min:7',
            'role' => 'required'

        ], [
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El correo electrónico debe tener un formato válido',
            'email.unique' => 'El correo electrónico ya está en uso',
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'lastname.required' => 'El apellido es requerido',
            'lastname.min' => 'El apellido debe tener al menos 3 caracteres',
            'document.required' => 'La cédula de identidad es requerida',
            'document.min' => 'La cédula de identidad debe tener al menos 7 dígitos',
            'role.required' => 'El Rol es requerida',
        ]);
    
        $permission->update( $request->all() );
        $permission->syncRoles([$request->role]);

        return response()->json([
            "message" => "La Usuario fue actualizado",
            "permission" => new PermissionResource($permission),
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);

        if( !$permission )
        {
            return response()->json([
                "message" => "No se encontro la Usuario",
            ], 404);
        }

        $permission->status = 0;
        $permission->save();
    
        
        return response()->json([
            "message" => "La Usuario fue eliminada",
            "permission" => $permission
        ], 200);
    }
}
