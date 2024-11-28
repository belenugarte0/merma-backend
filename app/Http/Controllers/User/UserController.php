<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\FullUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;


use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return new UserCollection($users);
    }


    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|unique:users|email',
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'document' => 'required|min:7',
            'phone' => 'nullable|numeric|digits_between:7,8',
            'role' => 'required'

        ];
        $message = [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'lastname.required' => 'El apellido es obligatorio.',
            'lastname.min' => 'El apellido debe tener al menos 3 caracteres.',
            'document.required' => 'La cédula de identidad es obligatoria.',
            'document.min' => 'La cédula de identidad debe tener al menos 7 dígitos.',
            'role.required' => 'El rol es obligatorio.',
            'phone.numeric' => 'El teléfono debe contener solo números.',
            'phone.digits_between' => 'El teléfono debe tener entre 7 y 8 dígitos.'
        ];
        // VALIDAR DATOS
        $request->validate($rules, $message);

        // GENERAR CONTRASEÑA
        $password = strtoupper(substr($request['name'], 0, 1) . substr($request['lastname'], 0, 1) . substr($request['document'], 0, 6));

        // GUARDAR EL USUARIO
        $user = User::create([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'document' => $request['document'],
            'password' => bcrypt($password),
            'phone' => $request['phone'],
            'role' => $request['role'],
        ]);

        // ASIGNAR ROL
        $user->assignRole($request['role']);

        // Enviar correo electrónico
        try {
            $correo = new EnviarCorreo($user->email, $password, $user->name);
            Mail::to($user->email)->queue($correo);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Hubo un problema al enviar el correo: " . $e->getMessage()
            ], 500);
        }

        
        // RETORNAR RESPUESTA JSON
        return response()->json([
            "message" => "EL USUARIO FUE REGISTRADO EXITOSAMENTE",
            "user" => new UserResource($user)
        ], 201);
    }

    public function show(string $term)
    {
        $user = User::where('id', $term)->get();

        // VALIDAR DE QUE EXISTA LA Usuario
        if (count($user) == 0) {
            return response()->json([
                "message" => "No se encontro la Usuario",
            ], 404);
        }

        return new FullUserResource($user[0]);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "message" => "No se encontró el Usuario",
            ], 404);
        }

        $rules = [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'document' => 'required|min:7',
            'phone' => 'nullable|numeric|digits_between:7,8',
            'role' => 'required'
        ];

        $messages = [
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
            'phone.numeric' => 'El teléfono debe contener solo números.',
            'phone.digits_between' => 'El teléfono debe tener entre 7 y 8 dígitos.'
        ];

        // VALIDAR DATOS
        $validatedData = $request->validate($rules, $messages);

        // ACTUALIZAR EL USUARIO
        $user->update($validatedData);
        $user->syncRoles([$request->role]);

        return response()->json([
            "message" => "EL USUARIO FUE ACTUALIZADO!",
            "user" => new UserResource($user),
        ], 200);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                "message" => "No se encontró el Usuario",
            ], 404);
        }

        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return response()->json([
            "message" => "EL USUARIO FUE ACTUALIZADO!",
            "user" => $user
        ], 200);
    }


}
