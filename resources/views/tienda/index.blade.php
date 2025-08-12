@extends("plantilla")

@section("contenido")

<div class="relative flex flex-col min-h-screen font-inter bg-gray-100">
    <!-- Contenedor de la imagen que ocupa 1/3 de la pantalla -->
    <div class="w-full h-1/3">
        <img 
            src="{{ asset("fotoInicio.png") }}" 
            alt="Imagen de inicio de la tienda" 
            class="w-full h-full object-fill"
        >
    </div>
    
    <!-- Botón de Cerrar Sesión en la esquina superior derecha -->
    <div class="absolute top-45 right-4 flex">
         <span style="font-family: 'Verdana_Italic', sans-serif;" class="text-xl italic font-bold text-red-800 text-center mb-8">
                {{ Auth::user()->name }} &nbsp; &nbsp;
            </span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button 
                type="submit" 
                class="bg-red-800 hover:bg-red-900 text-white font-bold rounded-lg shadow-lg transition duration-300 transform hover:scale-105"
            >
                <svg fill="#ffffff" height="40px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 500" enable-background="new 0 0 500 500" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M250,224c-4.4,0-8,3.6-8,8v24c0,4.4-3.6,8-8,8h-40c-4.4,0-8-3.6-8-8V144c0-4.4,3.6-8,8-8h40c4.4,0,8,3.6,8,8v24 c0,4.4,3.6,8,8,8s8-3.6,8-8v-24c0-13.2-10.8-24-24-24h-40c-13.2,0-24,10.8-24,24v112c0,13.2,10.8,24,24,24h40c13.2,0,24-10.8,24-24 v-24C258,227.6,254.4,224,250,224z"></path> <path d="M328.4,204.8c0.1-0.1,0.2-0.2,0.3-0.3c0,0,0,0,0-0.1c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.3,0.3-0.5,0.4-0.8 c0.1-0.3,0.2-0.5,0.3-0.8c0.1-0.2,0.2-0.4,0.2-0.7c0.2-1,0.2-2.1,0-3.1c0,0,0,0,0,0c0-0.2-0.1-0.4-0.2-0.7 c-0.1-0.3-0.1-0.5-0.2-0.8c0,0,0,0,0,0c-0.1-0.3-0.3-0.5-0.4-0.8c-0.1-0.2-0.2-0.4-0.3-0.6c-0.3-0.4-0.6-0.9-1-1.2l-32-32 c-3.1-3.1-8.2-3.1-11.3,0c-3.1,3.1-3.1,8.2,0,11.3l18.3,18.3H210c-4.4,0-8,3.6-8,8s3.6,8,8,8h92.7l-18.3,18.3 c-3.1,3.1-3.1,8.2,0,11.3c1.6,1.6,3.6,2.3,5.7,2.3s4.1-0.8,5.7-2.3l32-32c0,0,0,0,0,0C327.9,205.4,328.1,205.1,328.4,204.8z"></path> </g> </g></svg>
            </button>
        </form>
    </div>
    
    <!-- Contenedor principal de opciones que ocupa los 2/3 restantes -->
    <div class="flex-1 flex items-start justify-center p-4">
        <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl w-full max-w-sm sm:max-w-md">
            <h1 class="text-xl font-bold text-gray-900 text-center mb-4">
                Tienda
            </h1>
           
            
            <div class="bg-blue-50 p-4 rounded-lg text-center text-blue-800 border border-blue-200">
                <p>Aquí puedes explorar nuestro menú, gestionar tu cesta y ver tus pedidos.</p>
            </div>

            <!-- Opciones del menú del cliente -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="#" class="flex items-center justify-center p-4 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-200 transition duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    Ver Menú
                </a>
                <a href="#" class="flex items-center justify-center p-4 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-200 transition duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Mi Cesta
                </a>
                <a href="#" class="flex items-center justify-center p-4 bg-gray-100 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-200 transition duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M18 15v-1a2 2 0 00-2-2m-3 4a2 2 0 01-2-2V8a2 2 0 012-2h1a2 2 0 012 2v2a2 2 0 01-2 2z"></path></svg>
                    Mis Pedidos
                </a>
            </div>

            <!-- Horario de la tienda -->
            <div class="mt-8 pt-4 border-t border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 text-center mb-2">Horario</h2>
                <p class="text-gray-600 text-center">
                    Encargos de 18:30 a 23:30 y venta de 13:00 a 15:00
                </p>
                <p class="text-gray-600 text-center">
                    De lunes a viernes excepto festivos
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
