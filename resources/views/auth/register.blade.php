<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="gender" :value="__('Género')" />
            <select id="gender" name="gender" class="block mt-1 w-full" required>
                <option value="">Selecciona tu género</option>
                <option value="Hombre">Hombre</option>
                <option value="Mujer">Mujer</option>
                <option value="Otro">Otro</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Correo Electrónico -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

       <!-- Código de País -->
        <div class="mt-4">
            <x-input-label for="country_code" :value="__('Código de País')" />
            <select id="country_code" name="country_code" class="block mt-1 w-full">
                <option value="+52">+52 - México</option>
                <option value="+1">+1 - Estados Unidos / Canadá</option>
                <option value="+54">+54 - Argentina</option>
                <option value="+591">+591 - Bolivia</option>
                <option value="+56">+56 - Chile</option>
                <option value="+57">+57 - Colombia</option>
                <option value="+506">+506 - Costa Rica</option>
                <option value="+53">+53 - Cuba</option>
                <option value="+593">+593 - Ecuador</option>
                <option value="+503">+503 - El Salvador</option>
                <option value="+34">+34 - España</option>
                <option value="+502">+502 - Guatemala</option>
                <option value="+504">+504 - Honduras</option>
                <option value="+52">+52 - México</option>
                <option value="+505">+505 - Nicaragua</option>
                <option value="+507">+507 - Panamá</option>
                <option value="+595">+595 - Paraguay</option>
                <option value="+51">+51 - Perú</option>
                <option value="+1-809">+1-809 / +1-829 / +1-849 - República Dominicana</option>
                <option value="+598">+598 - Uruguay</option>
                <option value="+58">+58 - Venezuela</option>
                <option value="+44">+44 - Reino Unido</option>
                <option value="+61">+61 - Australia</option>
                <option value="+64">+64 - Nueva Zelanda</option>
            </select>
            <x-input-error :messages="$errors->get('country_code')" class="mt-2" />
        </div>


        <!-- Número de Teléfono -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Número de Teléfono')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botón de Registrarse -->
        <div class="flex items-center justify-center mt-4 flex-grow">
            <x-primary-button class="flex-grow justify-center">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>

        <div class="flex flex-col items-center mt-4 space-y-4">
            <!-- Botón de Google -->
            <a href="{{ route('google.login') }}" class="flex items-center justify-center bg-white text-red-500 border border-red-500 px-4 py-2 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <!-- SVG de Google -->
                <svg width="20px" height="20px" viewBox="-0.5 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title>Google-color</title>
                        <desc>Created with Sketch.</desc>
                        <defs></defs>
                        <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Color-" transform="translate(-401.000000, -860.000000)">
                                <g id="Google" transform="translate(401.000000, 860.000000)">
                                    <path d="M9.82727273,24 C9.82727273,22.4757333 10.0804318,21.0144 10.5322727,19.6437333 L2.62345455,13.6042667 C1.08206818,16.7338667 0.213636364,20.2602667 0.213636364,24 C0.213636364,27.7365333 1.081,31.2608 2.62025,34.3882667 L10.5247955,28.3370667 C10.0772273,26.9728 9.82727273,25.5168 9.82727273,24" id="Fill-1" fill="#FBBC05"></path>
                                    <path d="M23.7136364,10.1333333 C27.025,10.1333333 30.0159091,11.3066667 32.3659091,13.2266667 L39.2022727,6.4 C35.0363636,2.77333333 29.6954545,0.533333333 23.7136364,0.533333333 C14.4268636,0.533333333 6.44540909,5.84426667 2.62345455,13.6042667 L10.5322727,19.6437333 C12.3545909,14.112 17.5491591,10.1333333 23.7136364,10.1333333" id="Fill-2" fill="#EB4335"></path>
                                    <path d="M23.7136364,37.8666667 C17.5491591,37.8666667 12.3545909,33.888 10.5322727,28.3562667 L2.62345455,34.3946667 C6.44540909,42.1557333 14.4268636,47.4666667 23.7136364,47.4666667 C29.4455,47.4666667 34.9177955,45.4314667 39.0249545,41.6181333 L31.5177727,35.8144 C29.3995682,37.1488 26.7323182,37.8666667 23.7136364,37.8666667" id="Fill-3" fill="#34A853"></path>
                                    <path d="M46.1454545,24 C46.1454545,22.6133333 45.9318182,21.12 45.6113636,19.7333333 L23.7136364,19.7333333 L23.7136364,28.8 L36.3181818,28.8 C35.6879545,31.8912 33.9724545,34.2677333 31.5177727,35.8144 L39.0249545,41.6181333 C43.3393409,37.6138667 46.1454545,31.6490667 46.1454545,24" id="Fill-4" fill="#4285F4"></path>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
                &nbsp;
                {{ __('Iniciar sesión con Google') }}
            </a>

           

            <!-- Enlace para ya estás registrado -->
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('¿Ya estás registrado?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
