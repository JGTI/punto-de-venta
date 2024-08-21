<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SocialiteController extends Controller
{
    /**
     * Redirige al usuario al proveedor de Google para la autenticación.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja la respuesta del proveedor de Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            // Obtener la información del usuario de Google
            $user = Socialite::driver('google')->stateless()->user();

            // Buscar al usuario existente o crear uno nuevo
            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                // Iniciar sesión si el usuario ya existe
                Auth::login($existingUser);
            } else {
            
                // Crear un nuevo usuario y luego iniciar sesión
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id, // Puedes almacenar el ID de Google si lo deseas
                    'avatar' => $user->avatar,
                    'password' => Hash::make($user->avatar), // Generar una contraseña aleatoria
                    'role_id' => Role::where('name','ADMIN BUSSINESS')->first()->id,
                ]);

                Auth::login($newUser);
            }

            // Redirigir al usuario al dashboard o página principal
            return redirect()->route('welcome');
        } catch (\Exception $e) {
            dd('Error');
            // Manejar excepciones y redirigir al usuario en caso de error
            //return redirect()->route('home')->with('error', 'Ha ocurrido un error al iniciar sesión con Google.');
        }
    }
}
