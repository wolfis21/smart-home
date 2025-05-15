<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex items-center justify-center
        px-6 py-2 
        bg-blue-600 hover:bg-blue-700 
        text-white text-sm font-semibold 
        rounded transition duration-300
        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
        dark:focus:ring-offset-gray-800
    '
]) }}>
    {{ $slot }}
</button>
