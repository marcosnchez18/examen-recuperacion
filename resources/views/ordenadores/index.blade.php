<x-app-layout>
    <div class="relative overflow-x-auto w-3/4 mx-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">
                        Imagen
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('ordenadores.index', ['order' => 'ordenadores.marca', 'order_dir' => order_dir($order == 'ordenadores.marca', $order_dir)]) }}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Marca {{ order_dir_arrow($order == 'ordenadores.marca', $order_dir) }}
                        </a>
                    </th>
                    <th class="px-6 py-3">
                        Modelo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('ordenadores.index', ['order' => 'aulas.nombre', 'order_dir' => order_dir($order == 'aulas.nombre', $order_dir)]) }}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Aula {{ order_dir_arrow($order == 'aulas.nombre', $order_dir) }}
                        </a>
                    </th>
                    <th class="px-6 py-3">
                        Cantidad de dispositivos
                    </th>
                    <th class="px-6 py-3">
                        Editar
                    </th>
                    <th class="px-6 py-3">
                        Borrar
                    </th>
                </tr>
            </thead>
            <br><br><br>
            <tbody>
                @foreach ($ordenadores as $ordenador)
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if ($ordenador->existeImagen())
                                <img src="{{ asset($ordenador->imagen_url) }}" />
                            @endif
                        </th>
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <a href="{{ route('ordenadores.show', ['ordenador' => $ordenador]) }}"
                                class="text-blue-500">
                                {{ $ordenador->marca }}
                            </a>
                        </th>
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $ordenador->modelo }}
                        </th>
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $ordenador->aula->nombre }}
                        </th>
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $ordenador->cantidad_dispositivos() }}
                        </th>
                        <td class="px-6 py-4">
                            <a href="{{ route('ordenadores.edit', ['ordenador' => $ordenador]) }}"
                                class="font-medium text-blue-600 hover:underline">
                                <x-primary-button>
                                    Editar
                                </x-primary-button>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('ordenadores.destroy', ['ordenador' => $ordenador]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <x-primary-button class="bg-red-500">
                                    Borrar
                                </x-primary-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('ordenadores.create') }}" class="flex justify-center mt-4 mb-4">
            <x-primary-button class="bg-green-500">Insertar un nuevo ordenador</x-primary-button>
        </form>
    </div>
</x-app-layout>
