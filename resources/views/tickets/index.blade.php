<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wisata') }}
        </h2>
    </x-slot>

    <div class="py-2" style="background-color: white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('tickets.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-2 rounded">
                    + Tambah Wisata
                </a>
            </div>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto">
                    <div class="py-2 align-middle inline-block min-w-full">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr class="text-gray-500">
                                        <th scope="col" class="px-6 py-3 text-left font-bold">No</th>
                                        <th scope="col" class="px-6 py-3 text-center font-bold">Gambar</th>
                                        <th scope="col" class="px-6 py-3 text-left font-bold">Nama</th>
                                        <th scope="col" class="px-6 py-3 text-left font-bold">Lokasi</th>
                                        <th scope="col" class="px-6 py-3 text-left font-bold">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left font-bold">Harga</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $num = 1;
                                    @endphp
                                    @forelse ($tickets as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-left">
                                                {{ $num++ }}</td>
                                            <td class="py-4">
                                                <div class="flex">
                                                    <img class="mx-auto h-16 w-16 rounded-full"
                                                        src="{{ Storage::url($item->image) }}" alt="produk">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->lokasi }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->price }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->description }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex justify-center gap-1 font-bold text-center">
                                                        <a style="background-color: #efa961"
                                                            href="{{ route('tickets.edit', $item->id) }}"
                                                            class="text-white px-2 py-2 rounded w-20">Edit</a>
    
                                                        <form action="{{ route('tickets.destroy', $item->id) }}"
                                                            method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button style="background-color: #ff928a;color: darkred"
                                                                type="submit" class="font-bold px-2 py-2 rounded w-20">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="border text-center p-5">
                                                Data Tidak Ditemukan
                                            </td>
                                        </tr>
                                    @endforelse

                                    <!-- More people... -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
