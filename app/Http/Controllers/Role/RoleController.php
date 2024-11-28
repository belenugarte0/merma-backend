<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\FullRoleResource;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class RoleController extends Controller
{
    
    public function index()
    {
        $rolesWithPermissions = Role::with('permissions')->orderBy('id', 'asc')->get();
        $rolesArray = [];
        foreach ($rolesWithPermissions as $role) {
            $roleData = [
                'id' => $role->id,
                'name' => $role->name,
                'status' => $role->status,
                'permissions' => $role->permissions->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'grupo' => $permission->grupo,
                        'permission_id' => $permission->pivot->permission_id,
                        'role_id' => $permission->pivot->role_id,
                    ];
                })
            ];

            $rolesArray[] = $roleData;
        }

        return response()->json(['roles' => $rolesArray], 200);
    }
    
    public function store(Request $request)
    {
       
     $rules = [
           'name' => 'required|unique:roles|min:3',
            'permissions' => 'required|array',           
        ];
        $message=[
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'El nombre de rol ya está en uso',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'permissions.required' => 'Debe seleccionar al menos un permiso',
            'permissions.array' => 'Los permisos deben ser proporcionados en forma de matriz',
        ];
        $request->validate($rules, $message);

        // Crear el nuevo rol
        $role = Role::create(['name' => $request->name]);
    
        // Buscar los permisos por sus nombres
        $permissionNames = $request->permissions;
        $permissions = Permission::whereIn('name', $permissionNames)->get();
    
        // Sincronizar los permisos del nuevo rol
        $role->permissions()->sync($permissions);
    
        return response()->json([
            "message" => "EL ROL HA SIDO CREADO EXITOSAMENTE",
            "role" => $role,
        ], 201);
    }
    

  
    public function show($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return response()->json([
                'message' => 'EL ROL NO FUE ENCONTRADO',
            ], 404);
        }

        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();

        //$data['roles'] = $role;

        return response()->json([
            "permissions" => $rolePermissions
        ], 200);        
    }

    
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        if (!$role) {
            return response()->json([
                'message' => 'EL ROL NO FUE ENCONTRADO',
            ], 404);
        }

        $request->validate([
            'name' => 'required|min:3',
            'permissions' => 'required|array',
        ], [            
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'permissions.required' => 'Debe seleccionar al menos un permiso',
            'permissions.array' => 'Los permisos deben ser proporcionados en forma de matriz',
        ]);

        $role->update(['name' => $request->name]);

        // Buscar los permisos por sus nombres
        $permissionNames = $request->permissions;
        $permissions = Permission::whereIn('name', $permissionNames)->get();

        // Sincronizar los permisos del rol
        $role->permissions()->sync($permissions);

        return response()->json([
            "message" => "EL ROL FUE ACTUALIZADO",
            "role" => $role,
        ], 200);
    }
        


    public function destroy(string $id)
    {
       $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'message' => 'EL ROL NO FUE ENCONTRADO',
            ], 404);
        }

        // Alternar el estado del usuario
        $role->status = $role->status == 1 ? 0 : 1;
        $role->save();

        return response()->json([
            "message" => "EL ESTADO DEL ROL FUE ACTUALIZADO",
            "role" => $role
        ], 200);
    }
}
