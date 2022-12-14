<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::select('id', 'name', 'last_name', 'email', 'birth_date', 'gender')
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->paginate();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json(array(
            'message' => 'Usuario creado satisfactoriamente',
            'user' => $user
        ), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        return response()->json(array(
            'message' => $user? 'OK' : 'Usuario no encontrado',
            'user' => $user
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::find($id);

        $userUpdated = $user? $user->update($request->validated()) : null;

        return response()->json(array(
            'message' => ($userUpdated ? 'Datos actualizados correctamente' : 'No se pudo actualizar los datos del usuario')
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);

        $deleted = $user ? $user->delete() : null;

        return response()->json(
            array(
                'message' => ($deleted ? 'Usuario eliminado correctamente' : 'No se pudo eliminar al usuario')
            )
        );
    }
}
