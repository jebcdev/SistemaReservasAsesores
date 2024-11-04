<?php

namespace App\Http\Controllers\Modules\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUser\StoreAdminUserRequest;
use App\Http\Requests\AdminUser\UpdateAdminUserRequest;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends Controller
{

    public function index()
    {

        try {
            $users = User::query()->with([
                'role',
                'userDetail',
            ])
                ->get();

            return view('modules.admin.users.index', [
                'users' => $users,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create()
    {
        try {
            $user = new User();
            $user->load([
                'role',
                'userDetail',
            ]);
            $roles = Role::query()->orderBy('name')->get();
            return view('modules.admin.users.create', [
                'user' => $user,
                'roles' => $roles,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(StoreAdminUserRequest $request)
    {
        try {
            // Recoger todos los datos de la request
            $data = $request->validated();

            // Encriptar la contraseña
            $data['password'] = Hash::make($data['password']);

            // Crear el usuario
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role_id' => $data['role_id'],
            ]);

            // Preparar datos para el detalle de usuario
            $userDetailsData = [
                'lastname' => $data['lastname'],
                'phone' => $data['phone'],
            ];

            // Verificar si viene la imagen
            if ($request->hasFile('image')) {
                // Obtener el archivo
                $image = $request->file('image');

                // Generar un nombre único para la imagen
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                // Guardar la imagen en la carpeta especificada
                $image->move(public_path('assets/img/users'), $imageName);

                // Añadir el nombre de la imagen a los detalles del usuario
                $userDetailsData['image'] = $imageName;
            }

            // Crear el detalle del usuario
            $user->userDetail()->create($userDetailsData);

            return to_route('admin.users.index')->with('sessionMessage', __('User Created Successfully'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $user->load([
                'role',
                'userDetail',
            ]);

            return view('modules.admin.users.show', [
                'user' => $user,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function edit(User $user)
    {
        try {
            $user->load([
                'role',
                'userDetail',
            ]);

            $roles = Role::query()->orderBy('name')->get();

            return view('modules.admin.users.edit', [
                'user' => $user,
                'roles' => $roles,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(UpdateAdminUserRequest $request, User $user)
    {
        try {
            // Recoger todos los datos validados de la request
            $data = $request->validated();
    
            // Verificar si hay una nueva contraseña y encriptarla
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
    
            // Actualizar la información del usuario
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                // Solo actualiza la contraseña si se proporcionó una
                'password' => $data['password'] ?? $user->password,
            ]);
    
            // Preparar datos para el detalle del usuario
            $userDetailsData = [
                'lastname' => $data['lastname'],
                'phone' => $data['phone'],
            ];
    
            // Verificar si viene una nueva imagen en la request
            if ($request->hasFile('image')) {
                // Borrar la imagen anterior si existe
                if ($user->userDetail->image) {
                    $oldImagePath = public_path('assets/img/users/' . $user->userDetail->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
    
                // Subir la nueva imagen
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/img/users'), $imageName);
    
                // Añadir el nuevo nombre de la imagen a los detalles del usuario
                $userDetailsData['image'] = $imageName;
            }
    
            // Actualizar los detalles del usuario
            $user->userDetail()->update($userDetailsData);
    
            return to_route('admin.users.index')->with('sessionMessage', __('User Updated Successfully'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy(User $user)
    {
        try {
            // Borrar la imagen del usuario si existe
            if ($user->userDetail->image) {
                $imagePath = public_path('assets/img/users/' . $user->userDetail->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Borrar el usuario
            $user->delete();

            return to_route('admin.users.index')->with('sessionMessage', __('User Deleted Successfully'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}
