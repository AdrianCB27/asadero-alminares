@extends("plantilla")

@section("contenido")

    <div class="relative flex flex-col min-h-screen font-inter bg-neutral-200">
        <!-- Contenedor de la imagen que ocupa 1/3 de la pantalla -->
        <div class="w-full h-1/3">
            <img src="{{ asset("fotoinicio.jpg") }}" alt="Imagen de inicio de la web" class="w-full h-full object-fill">
        </div>

        <!-- Botón de Cerrar Sesión en la esquina superior derecha -->
        <div class="flex justify-center mt-4">
            <span style="font-family: 'Verdana_Italic', sans-serif;"
                class="text-xl italic font-bold text-red-800 text-center mb-8">
                {{ Auth::user()->name }}
            </span> &nbsp; &nbsp;
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-800 hover:bg-red-900 text-white font-bold rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                    <svg fill="#ffffff" height="40px" width="40px" version="1.1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 500"
                        enable-background="new 0 0 500 500" xml:space="preserve" stroke="#ffffff">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path
                                    d="M250,224c-4.4,0-8,3.6-8,8v24c0,4.4-3.6,8-8,8h-40c-4.4,0-8-3.6-8-8V144c0-4.4,3.6-8,8-8h40c4.4,0,8,3.6,8,8v24 c0,4.4,3.6,8,8,8s8-3.6,8-8v-24c0-13.2-10.8-24-24-24h-40c-13.2,0-24,10.8-24,24v112c0,13.2,10.8,24,24,24h40c13.2,0,24-10.8,24-24 v-24C258,227.6,254.4,224,250,224z">
                                </path>
                                <path
                                    d="M328.4,204.8c0.1-0.1,0.2-0.2,0.3-0.3c0,0,0,0,0-0.1c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.3,0.3-0.5,0.4-0.8 c0.1-0.3,0.2-0.5,0.3-0.8c0.1-0.2,0.2-0.4,0.2-0.7c0.2-1,0.2-2.1,0-3.1c0,0,0,0,0,0c0-0.2-0.1-0.4-0.2-0.7 c-0.1-0.3-0.1-0.5-0.2-0.8c0,0,0,0,0,0c-0.1-0.3-0.3-0.5-0.4-0.8c-0.1-0.2-0.2-0.4-0.3-0.6c-0.3-0.4-0.6-0.9-1-1.2l-32-32 c-3.1-3.1-8.2-3.1-11.3,0c-3.1,3.1-3.1,8.2,0,11.3l18.3,18.3H210c-4.4,0-8,3.6-8,8s3.6,8,8,8h92.7l-18.3,18.3 c-3.1,3.1-3.1,8.2,0,11.3c1.6,1.6,3.6,2.3,5.7,2.3s4.1-0.8,5.7-2.3l32-32c0,0,0,0,0,0C327.9,205.4,328.1,205.1,328.4,204.8z">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>
            </form>
        </div>

        <div class="flex-1 flex items-start justify-center px-4 pb-4 mb-20">
            <div class="bg-neutral-100 p-8 md:p-12 rounded-2xl shadow-xl w-full max-w-sm sm:max-w-md">
                <div class="flex items-center justify-center mb-4">
                    <h1 class="text-xl font-bold text-gray-900">Tienda</h1> &nbsp; &nbsp;
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input id="tienda-checkbox" type="checkbox" class="sr-only peer" {{ $setting->mostrar_tienda ? 'checked' : '' }}>
                        <div class="group peer ring-0 bg-rose-400 rounded-full outline-none duration-300 after:duration-300 w-16 h-8 shadow-md
                                                                peer-checked:bg-emerald-500 peer-focus:outline-none 
                                                                after:content-['✖️'] after:rounded-full after:absolute after:bg-gray-50 after:outline-none 
                                                                after:h-6 after:w-6 after:top-1 after:left-1 
                                                                after:flex after:justify-center after:items-center 
                                                                peer-checked:after:translate-x-8 peer-checked:after:content-['✔️'] 
                                                                peer-hover:after:scale-95">
                        </div>
                    </label>
                </div>

                <!-- <div class="bg-blue-50 p-4 rounded-lg text-center text-blue-800 border border-blue-200">
                                            <p class="text-sm">@if ($setting->mostrar_tienda)
                                                La tienda está activa.
                                            @else
                                                    La tienda está inactiva.
                                                @endif</p>
                                        </div> -->
                <ul class="divide-y divide-gray-200">
                    @foreach($productos as $producto)
                        <li class="py-2 flex items-center">
                            <div class="ml-0 flex-1 text-2xl ">
                                <div class="flex justify-center items-center">
                                    @if ($setting->mostrar_tienda && $producto->stock > 0)
                                        <a href="#" class="font-semibold text-red-800 text-center italic"
                                            onclick="showModal('{{ $producto->name }}', {{ $producto->price }}, {{ $producto->id }})">
                                            {{ $producto->name }}
                                        </a>
                                    @elseif ($producto->stock <= 0)
                                        <span class="font-semibold text-gray-400 text-center italic">{{ $producto->name }}
                                            (Agotado)</span>
                                    @else
                                        <span class="font-semibold text-red-800 text-center italic">{{ $producto->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <h2 class="text-center text-2xl font-bold text-gray-800 mb-4 mt-6">
                    Mensaje actual
                </h2>
                <form action="{{ route('cambiarMensaje') }}" method="post">
                    @csrf
                    <textarea name="mensaje" id="mensaje" rows="6"
                        class="w-full p-4 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-inner focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 transition duration-300 ease-in-out placeholder:text-gray-400">{!! $mensaje->texto !!}</textarea>

                    <input type="submit" value="Cambiar"
                        class="mt-4 w-full bg-red-800 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                </form>

            </div>
        </div>

        <!-- Footer fijo con botones -->
        <div class="fixed bottom-0 left-0 w-full bg-white shadow-inner border-t border-gray-300 z-50">
            <div class="flex justify-around p-2">
                <a href="" class="flex flex-col items-center text-sm text-gray-700 hover:text-blue-600">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M20 11.6211V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V11.6211M7.5 9.75C7.5 10.9926 6.49264 12 5.25 12C4.09397 12 3.14157 11.1282 3.01442 10.0062C2.99524 9.83688 3.02176 9.66657 3.06477 9.50173L4.10996 5.49516C4.3397 4.6145 5.13506 4 6.04519 4H17.9548C18.8649 4 19.6603 4.6145 19.89 5.49516L20.9352 9.50173C20.9782 9.66657 21.0048 9.83688 20.9856 10.0062C20.8584 11.1282 19.906 12 18.75 12C17.5074 12 16.5 10.9926 16.5 9.75M7.5 9.75C7.5 10.9926 8.50736 12 9.75 12C10.9926 12 12 10.9926 12 9.75M7.5 9.75L8 4M12 9.75C12 10.9926 13.0074 12 14.25 12C15.4926 12 16.5 10.9926 16.5 9.75M12 9.75V4M16.5 9.75L16 4"
                                stroke="#991B1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    Tienda
                </a>
                <a href="{{ route('pedidos.index') }}"
                    class="flex flex-col items-center text-sm text-gray-700 hover:text-blue-600">
                    <svg width="30px" height="30px" viewBox="0 0 1024.00 1024.00" fill="#991B1B" class="icon" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" transform="matrix(1, 0, 0, 1, 0, 0)rotate(0)">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#991B1B"
                            stroke-width="2.048"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M959.018 208.158c0.23-2.721 0.34-5.45 0.34-8.172 0-74.93-60.96-135.89-135.89-135.89-1.54 0-3.036 0.06-6.522 0.213l-611.757-0.043c-1.768-0.085-3.563-0.17-5.424-0.17-74.812 0-135.67 60.84-135.67 135.712l0.188 10.952h-0.306l0.391 594.972-0.162 20.382c0 74.03 60.22 134.25 134.24 134.25 1.668 0 7.007-0.239 7.1-0.239l608.934 0.085c2.985 0.357 6.216 0.468 9.55 0.468 35.815 0 69.514-13.954 94.879-39.302 25.373-25.34 39.344-58.987 39.344-94.794l-0.145-12.015h0.918l-0.008-606.41z m-757.655 693.82l-2.585-0.203c-42.524 0-76.146-34.863-76.537-79.309V332.671H900.79l0.46 485.186-0.885 2.865c-0.535 1.837-0.8 3.58-0.8 5.17 0 40.382-31.555 73.766-71.852 76.002l-10.816 0.621v-0.527l-615.533-0.01zM900.78 274.424H122.3l-0.375-65.934 0.85-2.924c0.52-1.82 0.782-3.63 0.782-5.247 0-42.236 34.727-76.665 78.179-76.809l0.45-0.068 618.177 0.018 2.662 0.203c42.329 0 76.767 34.439 76.767 76.768 0 1.326 0.196 2.687 0.655 4.532l0.332 0.884v68.577z"
                                fill=""></path>
                            <path
                                d="M697.67 471.435c-7.882 0-15.314 3.078-20.918 8.682l-223.43 223.439L346.599 596.84c-5.544-5.603-12.95-8.69-20.842-8.69s-15.323 3.078-20.918 8.665c-5.578 5.518-8.674 12.9-8.7 20.79-0.017 7.908 3.07 15.357 8.69 20.994l127.55 127.558c5.57 5.56 13.01 8.622 20.943 8.622 7.925 0 15.364-3.06 20.934-8.63l244.247-244.247c5.578-5.511 8.674-12.883 8.7-20.783 0.017-7.942-3.079-15.408-8.682-20.986-5.552-5.612-12.958-8.698-20.85-8.698z"
                                fill=""></path>
                        </g>
                    </svg> Pedidos
                </a>
                <a href="{{ route('productos.index') }} "
                    class="flex flex-col items-center text-sm text-gray-700 hover:text-blue-600">
                    <svg width="30px" height="30px" viewBox="0 0 1024 1024" fill="#991B1B" class="icon" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" stroke="#991B1B" stroke-width="6.144">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M961.094 190.992c-17.138 0-40.368-4.882-63.738-13.388-35.882-13.05-63.626-31.266-70.672-46.412-2.812-6.044-2.124-10.818-1.062-13.754 3.218-8.858 13.262-13.35 29.838-13.35 17.152 0 40.38 4.882 63.768 13.404 20.778 7.552 39.524 17.152 52.786 27.034 16.184 12.05 22.558 23.19 18.95 33.094-3.22 8.872-13.28 13.372-29.87 13.372z m-105.636-70.908c-10.436 0-14.31 2.18-14.874 2.938-0.282 4.376 18.262 23.558 62.238 39.554 21.682 7.888 42.928 12.42 58.27 12.42 10.45 0 14.34-2.188 14.886-2.954 0.296-4.368-18.262-23.536-62.222-39.524-21.712-7.902-42.958-12.434-58.298-12.434zM911.26 287.692a9.4 9.4 0 0 1-1.032-0.062c-14.764-1.906-31.51-6.164-48.444-12.326-16.856-6.116-32.414-13.592-44.944-21.622-3.718-2.382-4.782-7.326-2.406-11.052 2.376-3.732 7.294-4.81 11.06-2.412 11.53 7.396 25.962 14.332 41.742 20.048 15.856 5.774 31.43 9.74 45.022 11.49a8.008 8.008 0 0 1 6.92 8.958 7.99 7.99 0 0 1-7.918 6.978z"
                                fill=""></path>
                            <path
                                d="M731.282 408.026c-0.906 0-1.828-0.156-2.734-0.484a7.988 7.988 0 0 1-4.78-10.248l101.854-279.848a8 8 0 0 1 10.248-4.782 7.99 7.99 0 0 1 4.78 10.248L738.794 402.76a8 8 0 0 1-7.512 5.266zM901.512 408.042c-0.906 0-1.844-0.156-2.734-0.484a7.99 7.99 0 0 1-4.782-10.248l81.938-225.156c1.5-4.156 6.108-6.28 10.248-4.782a7.99 7.99 0 0 1 4.78 10.248l-81.936 225.156a7.988 7.988 0 0 1-7.514 5.266zM766.29 405.728a7.99 7.99 0 0 1-7.514-10.732l54.864-150.782a8.02 8.02 0 0 1 10.248-4.78 7.988 7.988 0 0 1 4.782 10.248l-54.866 150.782a7.99 7.99 0 0 1-7.514 5.264zM867.442 408.042c-0.906 0-1.828-0.156-2.734-0.484a7.988 7.988 0 0 1-4.782-10.248l43.804-120.35c1.5-4.148 6.108-6.274 10.246-4.782a7.99 7.99 0 0 1 4.782 10.248l-43.802 120.35a8.006 8.006 0 0 1-7.514 5.266zM951.906 488.008H8.104c-4.422 0-8-3.576-8-7.998V432.02a7.994 7.994 0 0 1 8-7.998h415.914c4.42 0 8 3.578 8 7.998a7.994 7.994 0 0 1-8 7.998H16.102v31.994h927.806v-31.994H535.992a7.992 7.992 0 0 1-7.996-7.998 7.992 7.992 0 0 1 7.996-7.998h415.914c4.422 0 8 3.578 8 7.998v47.99a7.994 7.994 0 0 1-8 7.998z"
                                fill=""></path>
                            <path
                                d="M823.934 951.912H136.078a7.992 7.992 0 0 1-7.834-6.374l-95.98-463.912a8.008 8.008 0 0 1 6.218-9.452c4.272-0.922 8.552 1.882 9.452 6.216l94.66 457.524H817.42l94.652-457.524c0.904-4.334 5.124-7.138 9.466-6.216a8.03 8.03 0 0 1 6.216 9.452l-95.98 463.912a8.004 8.004 0 0 1-7.84 6.374z"
                                fill=""></path>
                            <path
                                d="M823.934 951.912a7.972 7.972 0 0 1-6.654-3.56 7.988 7.988 0 0 1 2.216-11.092l45.274-30.166 90.886-436.434c0.89-4.318 5.032-7.17 9.466-6.194a7.99 7.99 0 0 1 6.186 9.458L879.75 913.56a7.942 7.942 0 0 1-3.39 5.016l-47.988 31.992a8.03 8.03 0 0 1-4.438 1.344zM480.006 855.934c-17.644 0-31.994-14.342-31.994-31.994V599.984c0-17.636 14.348-31.992 31.994-31.992S512 582.348 512 599.984V823.94c0 17.652-14.348 31.994-31.994 31.994z m0-271.946c-8.818 0-15.998 7.188-15.998 15.996V823.94c0 8.826 7.178 15.996 15.998 15.996s15.998-7.17 15.998-15.996V599.984c-0.002-8.808-7.18-15.996-15.998-15.996zM304.042 855.934c-17.644 0-31.994-14.342-31.994-31.994l-15.974-223.376c-0.024-18.214 14.326-32.57 31.97-32.57s31.994 14.356 31.994 31.992l15.974 223.392c0.024 18.214-14.326 32.556-31.97 32.556z m-15.996-271.946c-8.818 0-15.998 7.188-15.998 15.996l15.974 223.392c0.024 9.388 7.202 16.558 16.02 16.558s15.998-7.17 15.998-15.996l-15.974-223.376c-0.024-9.386-7.202-16.574-16.02-16.574zM655.968 855.934c-17.652 0-31.994-14.342-31.994-31.994l16.03-224.518c-0.032-17.074 14.308-31.43 31.96-31.43s31.994 14.356 31.994 31.992l-16.03 224.534c0.032 17.074-14.306 31.416-31.96 31.416z m15.996-271.946c-8.81 0-15.996 7.188-15.996 15.996l-16.028 224.534c0.032 8.248 7.216 15.418 16.028 15.418s15.996-7.17 15.996-15.996l16.028-224.518c-0.032-8.246-7.216-15.434-16.028-15.434zM8.112 440.018a7.994 7.994 0 0 1-4.446-14.652l47.99-31.994a7.988 7.988 0 0 1 11.092 2.218 7.994 7.994 0 0 1-2.218 11.092L12.54 438.676a8.012 8.012 0 0 1-4.428 1.342zM951.906 440.018a7.97 7.97 0 0 1-6.654-3.56 7.988 7.988 0 0 1 2.218-11.092l47.99-31.994a7.99 7.99 0 0 1 11.092 2.218 7.99 7.99 0 0 1-2.218 11.092l-47.99 31.994a8.04 8.04 0 0 1-4.438 1.342z"
                                fill=""></path>
                            <path
                                d="M951.906 488.008a7.976 7.976 0 0 1-6.654-3.56 7.988 7.988 0 0 1 2.218-11.092l47.99-31.994a8 8 0 0 1 8.874 13.31l-47.99 31.992a8.024 8.024 0 0 1-4.438 1.344zM999.896 408.026h-15.996a7.994 7.994 0 0 1-7.998-7.998 7.994 7.994 0 0 1 7.998-7.998h15.996a7.992 7.992 0 0 1 7.998 7.998 7.994 7.994 0 0 1-7.998 7.998zM72.09 408.026h-15.998a7.994 7.994 0 0 1-7.998-7.998 7.994 7.994 0 0 1 7.998-7.998h15.998a7.994 7.994 0 0 1 7.998 7.998 7.994 7.994 0 0 1-7.998 7.998z"
                                fill=""></path>
                            <path
                                d="M999.896 456.016a7.994 7.994 0 0 1-7.998-7.998v-47.99a7.994 7.994 0 0 1 7.998-7.998 7.992 7.992 0 0 1 7.998 7.998v47.99a7.994 7.994 0 0 1-7.998 7.998zM504 464.014a7.994 7.994 0 0 1-7.998-7.998V120.084h-31.994v335.932c0 4.42-3.578 7.998-7.998 7.998s-7.998-3.578-7.998-7.998V112.086a7.994 7.994 0 0 1 7.998-7.998H504a7.994 7.994 0 0 1 7.998 7.998v343.93a7.992 7.992 0 0 1-7.998 7.998zM551.99 376.032a7.992 7.992 0 0 1-7.998-7.998V80.094c0-4.422 3.576-8 7.998-8a7.994 7.994 0 0 1 7.998 8v287.94a7.994 7.994 0 0 1-7.998 7.998z"
                                fill=""></path>
                            <path
                                d="M504.008 120.084a7.98 7.98 0 0 1-6.662-3.56 7.992 7.992 0 0 1 2.218-11.092l47.988-31.994c3.688-2.458 8.638-1.46 11.092 2.218s1.468 8.638-2.218 11.092l-47.988 31.994a8.008 8.008 0 0 1-4.43 1.342zM456.018 120.084a7.98 7.98 0 0 1-6.662-3.56 7.992 7.992 0 0 1 2.218-11.092l47.99-31.994a7.988 7.988 0 0 1 11.09 2.218 7.992 7.992 0 0 1-2.218 11.092l-47.99 31.994a7.998 7.998 0 0 1-4.428 1.342zM567.986 408.026h-31.994a7.992 7.992 0 0 1-7.996-7.998 7.992 7.992 0 0 1 7.996-7.998h31.994a7.992 7.992 0 0 1 7.998 7.998 7.994 7.994 0 0 1-7.998 7.998zM951.906 408.026a8.02 8.02 0 0 1-4.436-1.344 7.986 7.986 0 0 1-2.218-11.092l63.986-95.98c2.438-3.686 7.39-4.67 11.092-2.216a7.98 7.98 0 0 1 2.218 11.09l-63.986 95.98a7.972 7.972 0 0 1-6.656 3.562z"
                                fill=""></path>
                            <path
                                d="M1015.894 312.044h-47.99a7.994 7.994 0 0 1-7.998-7.998 7.992 7.992 0 0 1 7.998-7.998h47.99a7.994 7.994 0 0 1 7.998 7.998 7.994 7.994 0 0 1-7.998 7.998zM328.038 408.042c-4.422 0-8-3.578-8-7.998v-87.998H176.07v87.998a7.994 7.994 0 0 1-7.998 7.998c-4.422 0-8-3.578-8-7.998v-95.996a7.994 7.994 0 0 1 8-7.998h159.966a7.994 7.994 0 0 1 7.998 7.998v95.996a7.996 7.996 0 0 1-7.998 7.998zM424.018 408.026h-63.988a7.994 7.994 0 0 1-7.998-7.998 7.994 7.994 0 0 1 7.998-7.998h63.988a7.998 7.998 0 1 1 0 15.996z"
                                fill=""></path>
                            <path
                                d="M328.046 312.044a7.99 7.99 0 0 1-6.664-3.562l-31.994-47.99a7.99 7.99 0 0 1 2.218-11.09 7.994 7.994 0 0 1 11.09 2.216l31.994 47.99a7.992 7.992 0 0 1-6.644 12.436z"
                                fill=""></path>
                            <path
                                d="M296.044 264.054H136.078a7.994 7.994 0 0 1-7.998-7.998 7.994 7.994 0 0 1 7.998-7.998h159.966a7.994 7.994 0 0 1 7.998 7.998 7.994 7.994 0 0 1-7.998 7.998z"
                                fill=""></path>
                            <path
                                d="M168.08 312.044a7.99 7.99 0 0 1-6.664-3.562l-31.992-47.99a7.99 7.99 0 0 1 2.218-11.09 7.99 7.99 0 0 1 11.09 2.216l31.994 47.99a7.992 7.992 0 0 1-6.646 12.436z"
                                fill=""></path>
                            <path
                                d="M104.076 312.044a7.992 7.992 0 0 1-6.646-12.436l31.994-47.99a7.984 7.984 0 0 1 11.09-2.216 7.992 7.992 0 0 1 2.218 11.09L110.74 308.482a7.99 7.99 0 0 1-6.664 3.562z"
                                fill=""></path>
                            <path
                                d="M104.084 408.026c-4.42 0-8-3.578-8-7.998v-95.98c0-4.422 3.578-7.998 8-7.998s7.998 3.576 7.998 7.998v95.98a7.994 7.994 0 0 1-7.998 7.998zM136.078 408.026a7.994 7.994 0 0 1-7.998-7.998v-79.984c0-4.42 3.578-7.998 7.998-7.998s7.998 3.578 7.998 7.998v79.984a7.994 7.994 0 0 1-7.998 7.998zM296.044 264.054H136.078a7.994 7.994 0 0 1-7.998-7.998v-31.994a7.994 7.994 0 0 1 7.998-7.998h159.966a7.994 7.994 0 0 1 7.998 7.998v31.994a7.994 7.994 0 0 1-7.998 7.998z m-151.968-15.996h143.97v-15.998H144.076v15.998zM551.99 88.092H504a7.994 7.994 0 0 1-7.998-7.998c0-4.422 3.578-8 7.998-8h47.99a7.994 7.994 0 0 1 7.998 8 7.994 7.994 0 0 1-7.998 7.998zM695.96 408.026c-4.422 0-8-3.578-8-7.998 0-22.05-17.934-39.992-39.99-39.992-22.058 0-39.992 17.942-39.992 39.992a7.994 7.994 0 0 1-7.998 7.998 7.994 7.994 0 0 1-7.998-7.998c0-30.87 25.12-55.988 55.988-55.988s55.988 25.12 55.988 55.988a7.994 7.994 0 0 1-7.998 7.998zM663.966 328.042h-31.994a7.994 7.994 0 0 1-7.998-7.998 7.994 7.994 0 0 1 7.998-7.998h31.994a7.994 7.994 0 0 1 7.998 7.998 7.994 7.994 0 0 1-7.998 7.998z"
                                fill=""></path>
                            <path
                                d="M631.972 344.04a7.994 7.994 0 0 1-7.998-8v-15.996a7.994 7.994 0 0 1 7.998-7.998c4.422 0 8 3.578 8 7.998v15.996c0 4.42-3.578 8-8 8z"
                                fill=""></path>
                            <path
                                d="M663.966 344.04a7.994 7.994 0 0 1-7.998-8v-15.996c0-4.42 3.578-7.998 7.998-7.998s7.998 3.578 7.998 7.998v15.996c0 4.42-3.578 8-7.998 8z"
                                fill=""></path>
                            <path
                                d="M695.96 312.044c-0.5 0-1.032-0.046-1.562-0.156l-79.984-15.996a7.988 7.988 0 0 1-6.28-9.412c0.876-4.336 5.06-7.204 9.404-6.274l79.984 15.998a7.988 7.988 0 0 1 6.28 9.412 7.986 7.986 0 0 1-7.842 6.428z"
                                fill=""></path>
                            <path
                                d="M615.976 328.042a7.992 7.992 0 0 1-7.998-7.998v-31.992c0-4.422 3.576-8 7.998-8s7.998 3.578 7.998 8v31.992a7.994 7.994 0 0 1-7.998 7.998z"
                                fill=""></path>
                            <path
                                d="M695.96 328.042h-79.984a7.992 7.992 0 0 1-7.998-7.998 7.994 7.994 0 0 1 7.998-7.998h79.984a7.994 7.994 0 0 1 7.998 7.998 7.994 7.994 0 0 1-7.998 7.998z"
                                fill=""></path>
                            <path
                                d="M695.96 328.042c-4.422 0-8-3.576-8-7.998v-15.996a7.994 7.994 0 0 1 8-7.998 7.994 7.994 0 0 1 7.998 7.998v15.996a7.994 7.994 0 0 1-7.998 7.998z"
                                fill=""></path>
                            <path
                                d="M283.82 408.01a7.966 7.966 0 0 1-5.958-2.664c-15.138-16.902-44.388-16.942-59.59-0.008a7.98 7.98 0 0 1-11.294 0.61 7.996 7.996 0 0 1-0.61-11.294 56.08 56.08 0 0 1 41.686-18.622 56.082 56.082 0 0 1 41.726 18.644 8.004 8.004 0 0 1-5.96 13.334z"
                                fill=""></path>
                            <path
                                d="M504 464.014h-47.99a7.994 7.994 0 0 1-7.998-7.998 7.994 7.994 0 0 1 7.998-7.998H504a7.994 7.994 0 0 1 7.998 7.998 7.992 7.992 0 0 1-7.998 7.998z"
                                fill=""></path>
                        </g>
                    </svg>

                    Productos
                </a>
                <a href="{{ route('clientes.index') }}"
                    class="flex flex-col items-center text-sm text-gray-700 hover:text-blue-600">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z"
                                stroke="#991B1B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    Clientes
                </a>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('tienda-checkbox');

            checkbox.addEventListener('change', function () {
                const isChecked = this.checked;

                fetch('{{ route('cambiarTienda') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 'mostrar_tienda': isChecked })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Aquí puedes mostrar una notificación de éxito o error si lo deseas
                        if (data.success) {
                            window.location.reload(); // Recargar la página para aplicar el cambio
                        } else {
                            alert('Hubo un error al actualizar el estado.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un error en la conexión.');
                    });
            });
        });
    </script>
@endsection