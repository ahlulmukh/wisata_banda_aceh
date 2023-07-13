<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Semua Transaksi Top Up Saldo') }}
        </h2>
    </x-slot>

    <div class="py-2" style="background-color: white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto">
                  <div class="py-2 align-middle inline-block">
                    <div style="width: 70%" class="shadow overflow-hidden border-b w-auto border-gray-200 sm:rounded-lg">
                      <table style="width: 100%" class="divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                          <tr class="text-gray-500">
                            <th scope="col" class="px-6 py-3 text-left font-bold">No</th>
                            <th scope="col" class="px-6 py-3 text-left font-bold">User</th>
                            <th scope="col" class="px-6 py-3 text-left font-bold">Saldo</th>
                            <th scope="col" class="px-6 py-3 text-left font-bold">Bukti Pembayaran</th>
                            <th scope="col" class="px-6 py-3 text-left font-bold">Status</th>
                            <th scope="col" class="relative px-6 py-3">
                              <span class="sr-only">Action</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                          @php
                              $num = 1;
                          @endphp
                          @forelse ($saldo as $item)
                            <tr>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $num++ }}
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->user->name }}
                            </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->saldo }}
                                </td>
                                <td class="py-4">
                                  <div class="flex">
                                      <button onclick="showImagePopup('{{ Storage::url($item->image) }}')" class="mx-auto h-16 w-16 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none">
                                          Lihat
                                      </button>
                                  </div>
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->status }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                              <div class="flex justify-center gap-1 font-bold text-center">
                                  @if ($item->status === 'success')
                                      <span class="text-green-500">Terkonfirmasi</span>
                                  @elseif ($item->status === 'gagal')
                                      <span class="text-red-500">Gagal</span>
                                  @else
                                      <a style="background-color: #efa961" href="{{ route('saldo.konfirmasi', $item->id) }}" class="text-white px-2 py-2 rounded w-20">Konfirmasi</a>
                                      <form action="{{ route('saldo.tolak', $item->id) }}" method="POST" class="inline">
                                          @csrf
                                          <button type="submit" class="text-red-600 px-2 py-2 rounded w-20">Tolak</button>
                                      </form>
                                  @endif
                              </div>
                          </td>
                            </tr>
                          @empty

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

    <!-- Image Popup -->
<!-- Image Popup -->
<div id="imagePopup" class="fixed top-0 left-0 flex items-center justify-center w-full h-full bg-gray-900 bg-opacity-75 hidden">
  <div class="bg-white rounded-lg p-4">
      <button onclick="hideImagePopup()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
      </button>
      <div class="flex justify-center">
          <img id="popupImage" class="max-w-full max-h-screen" src="" alt="gambar">
      </div>
  </div>
</div>

<script>
  // Function to show image popup
  function showImagePopup(imageUrl) {
      var popupImage = document.getElementById('popupImage');
      popupImage.src = imageUrl;

      var imagePopup = document.getElementById('imagePopup');
      imagePopup.style.display = 'flex';
  }

  // Function to hide image popup
  function hideImagePopup() {
      var imagePopup = document.getElementById('imagePopup');
      imagePopup.style.display = 'none';
  }
</script>
</x-app-layout>
