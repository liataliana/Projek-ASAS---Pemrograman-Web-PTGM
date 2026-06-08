<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sewa Produk: ' . $product->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('rentals.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Durasi Sewa</label>
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <input type="number" name="duration_value" required 
                                           class="w-full border rounded px-3 py-2"
                                           placeholder="Jumlah">
                                </div>
                                <div class="flex-1">
                                    <select name="duration_unit" required class="w-full border rounded px-3 py-2">
                                        <option value="hours">Jam</option>
                                        <option value="days">Hari</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4">
                            <p class="text-yellow-700">
                                💡 <strong>Informasi:</strong> Setelah checkout, Anda harus menunggu konfirmasi dari admin. 
                                Masa sewa akan mulai setelah dikonfirmasi.
                            </p>
                        </div>

                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                            Checkout (Simulasi Pembayaran)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>