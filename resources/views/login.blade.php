@extends("plantilla")
@section("contenido")
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl w-full max-w-sm sm:max-w-md mx-auto my-auto">
            <div class="flex flex-col items-center mb-8">
                <img src="{{asset("logo.png")}}" alt="Logo de Asador Los Alminares"
                    class="w-24 h-24 mb-4 rounded shadow-md">
                <h1 style="font-family: 'Verdana_Italic', sans-serif;"
                    class="text-2xl sm:text-4xl text-gray-900 text-center italic font-bold">
                    Asador Los Alminares
                </h1>
                <p class="text-xl font-semibold text-gray-600 mt-2">
                    Inicio
                </p>
            </div>

            <form action="{{route("logged")}}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input type="name" id="name" name="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200"
                        placeholder="Ingresa tu nombre" required>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                    <input type="tel" id="phone_number" name="phone_number"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200"
                        placeholder="Ingresa tu número de teléfono" required>
                </div>

                <button type="submit"
                    class="w-full bg-red-800 text-white font-bold py-3 rounded-lg shadow-md hover:bg-red-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Iniciar la aplicación
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <p class="text-gray-600">
                    ¿No tienes una cuenta?
                    <a href="{{route('registroVista')}}"
                        class="font-semibold text-red-800 hover:text-red-700 hover:underline">Regístrate</a>
                </p>
            </div>
        </div>
    </div>
@endsection