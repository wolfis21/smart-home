<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartHomeIA - Automatiza. Ahorra. Protege.</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a2143e0',
                        accent: '#3B82F6',
                        lime: '#10B981',
                        graylight: '#E5E7EB',
                        light: '#FFFFFF'
                    },
                    fontFamily: {
                        heading: ['Montserrat', 'sans-serif'],
                        body: ['Open Sans', 'sans-serif']
                    },
                    keyframes: {
                        bounceIn: {
                            '0%': {
                                opacity: 0,
                                transform: 'scale(0.6) translateY(-30px)'
                            },
                            '60%': {
                                opacity: 1,
                                transform: 'scale(1.1) translateY(10px)'
                            },
                            '100%': {
                                transform: 'scale(1) translateY(0)'
                            }
                        },
                        fadeUp: {
                            '0%': { opacity: 0, transform: 'translateY(20px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' }
                        },
                        fadeIn: {
                            '0%': { opacity: 0 },
                            '100%': { opacity: 1 }
                        }
                    },
                    animation: {
                        fadeUp: 'fadeUp 1s ease-out forwards',
                        fadeIn: 'fadeIn 1s ease-in-out forwards',
                        bounceIn: 'bounceIn 1.2s ease-out forwards'
                    }

                }
            }
        }
    </script>
</head>
<body class="bg-primary text-light font-body">
    <div class="flex flex-col items-center justify-center min-h-screen px-6 text-center">
        <div class="bg-white rounded-full p-4 mb-6 animate-bounceIn shadow-lg shadow-blue-500/20">
            <img src="{{ asset('img/logo-smarthomeIA-2-v2.png') }}" alt="Logo SmartHomeIA" class="w-32 lg:w-48 h-auto mx-auto">
        </div>

        <h1 class="text-4xl font-heading mb-2 animate-fadeUp">SmartHomeIA</h1>
        <p class="text-lg text-lime font-semibold mb-1 animate-fadeUp">Automatiza. Ahorra. Protege.</p>
        <p class="max-w-xl text-gray-300 mt-4 animate-fadeUp">
            Plataforma inteligente de automatización para el hogar. Mejora tu eficiencia energética, refuerza tu seguridad y controla todo desde un solo lugar, impulsado por IA.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-4 animate-fadeUp">
            <a href="{{ route('login') }}" class="bg-accent hover:bg-blue-700 text-white px-6 py-3 rounded font-semibold transition-all duration-300">
                Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="bg-lime hover:bg-green-700 text-white px-6 py-3 rounded font-semibold transition-all duration-300">
                Registrarse
            </a>
        </div>

        <footer class="text-sm text-gray-400 mt-10 animate-fadeUp">
            &copy; {{ date('Y') }} SmartHomeIA. Todos los derechos reservados.
        </footer>
    </div>
</body>
</html>
