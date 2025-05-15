<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-[#0a2143] px-6 py-8">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md animate-fadeUp">
            
            {{-- Logo centrado --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/logo-smarthomeIA-2-v2.png') }}" alt="Logo" class="w-24 h-auto">
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Correo electrónico')" />
                    <x-text-input id="email" class="block mt-1 w-full text-gray-800" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full text-gray-800" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember Me --}}
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                    <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                        {{ __('Iniciar sesión') }}
                    </x-primary-button>
                </div>
            </form>
            {{-- Enlace a registro --}}
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>

        <p class="text-gray-400 mt-6 text-sm">&copy; {{ date('Y') }} SmartHomeIA</p>
    </div>
</x-guest-layout>
