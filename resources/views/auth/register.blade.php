<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-[#0a2143] px-6 py-8">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md animate-fadeUp">
            
            {{-- Logo centrado --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/logo-smarthomeIA-2-v2.png') }}" alt="Logo" class="w-24 h-auto">
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" class="block mt-1 w-full text-gray-800" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Correo electrónico')" />
                    <x-text-input id="email" class="block mt-1 w-full text-gray-800" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full text-gray-800" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirm Password --}}
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full text-gray-800" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-blue-600 hover:text-blue-800" href="{{ route('login') }}">
                        ¿Ya estás registrado?
                    </a>

                    <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                        {{ __('Registrarse') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <p class="text-gray-400 mt-6 text-sm">&copy; {{ date('Y') }} SmartHomeIA</p>
    </div>
</x-guest-layout>
