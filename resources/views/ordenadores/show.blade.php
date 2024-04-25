<x-app-layout>
    <div class="relative overflow-x-auto w-3/4 mx-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">
                        Marca
                    </th>
                    <th class="px-6 py-3">
                        Modelo
                    </th>
                    <th class="px-6 py-3">
                        Nombre Aula
                    </th>
                    <th class="px-6 py-3">
                        Origen
                    </th>
                    <th class="px-6 py-3">
                        Destino
                    </th>
                    <th class="px-6 py-3">
                        Fecha cambio
                    </th>
                    <th class="px-6 py-3">
                        Dispositivos que contiene
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $ordenador->marca }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $ordenador->modelo }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $ordenador->aula->nombre }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {!! $ordenador->comprueba_origen() !!}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {!! $ordenador->comprueba_destino() !!}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {!! $ordenador->fecha_cambio() !!}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $ordenador->dispositivos_contenidos() }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('ordenadores.index') }}">
                <x-secondary-button class="ms-4">
                    Volver
                    </x-primary-button>
            </a>
        </div>
    </div>
</x-app-layout>
