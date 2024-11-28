<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User; 
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class LogController extends Controller
{

    public function index()
    {
       $logs = Log::with('user')->orderBy('created_at', 'asc')->get();

        foreach ($logs as $log) {
            $log->id_user = $log->user->name;
            unset($log->user); 
        }

        return response()->json(['logs' => $logs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // VALIDAR DATOS
        $user = $request->validated();
        // GUARDAR EL REQUEST VALIDADO
        User::create( $user );


        // RETORNAR MENSAJE DE GUARDADO 
        return response()->json([
            "message" => "La Usuario fue registrada",
            "user" => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $term)
    {
        $user = User::where('id', $term)->get();


        // VALIDAR DE QUE EXISTA LA Usuario
        if( count($user) == 0 )
        {
            return response()->json([
                "message" => "No se encontro la Usuario",
            ], 404);
        }

        return new FullUserResource($user[0]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if( !$user )
        {
            return response()->json([
                "message" => "No se encontro la Usuario",
            ], 404);
        }
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
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
    
        $user->update( $request->all() );
        $user->syncRoles([$request->role]);

        return response()->json([
            "message" => "La Usuario fue actualizado",
            "user" => new UserResource($user),
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if( !$user )
        {
            return response()->json([
                "message" => "No se encontro la Usuario",
            ], 404);
        }

        $user->status = 0;
        $user->save();
    
        
        return response()->json([
            "message" => "La Usuario fue eliminada",
            "user" => $user
        ], 200);
    }
}
