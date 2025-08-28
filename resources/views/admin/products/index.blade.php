<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Yönetici Paneli - Ürünler') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="productList()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Yönetilen Ürünler</h3>
                    <div class="flex items-center space-x-2">
                        <!-- Seçilenleri Sil Butonu -->
                        <button
                            x-show="selectedProducts.length > 0"
                            x-cloak
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                            @click="showBulkConfirm = true"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Seçilenleri Sil (<span x-text="selectedProducts.length"></span>)
                        </button>

                        <!-- Yeni Ürün Ekle Butonu -->
                        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Yeni Ürün Ekle
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">ID</th>
                            <th scope="col" class="py-3 px-6">Resim</th>
                            <th scope="col" class="py-3 px-6">Başlık</th>
                            <th scope="col" class="py-3 px-6">Kalori</th>
                            <th scope="col" class="py-3 px-6">İşlemler</th>
                            <!-- Tümünü Seç Checkbox'ı En Sağa Taşındı -->
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all" type="checkbox"
                                           x-model="selectAll"
                                           @change="selectedProducts = selectAll ? Array.from(document.querySelectorAll('.product-checkbox')).map(el => el.value) : []"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500">
                                    <label for="checkbox-all" class="sr-only">Tümünü Seç</label>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($products as $product)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6">{{ $product->id }}</td>
                                <td class="py-4 px-6">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-16 h-16 object-cover rounded-md">
                                    @else
                                        <img src="https://placehold.co/64x64/E2E8F0/94A3B8?text=Yok" alt="Resim Yok" class="w-16 h-16 object-cover rounded-md">
                                    @endif
                                </td>
                                <td class="py-4 px-6">{{ $product->title }}</td>
                                <td class="py-4 px-6">{{ number_format($product->calories, 2, ',', '.') }} Kalori</td>
                                <td class="py-4 px-6">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-blue-600 hover:underline">Düzenle</a>

                                        <form
                                            id="delete-form-{{ $product->id }}"
                                            action="{{ route('admin.products.destroy', $product) }}"
                                            method="POST"
                                            @submit.prevent
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="button"
                                                @click="confirmDelete({{ $product->id }}, '{{ addslashes($product->title) }}')"
                                                class="font-medium text-red-600 hover:underline"
                                            >
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <!-- Ürün Checkbox'ı En Sağa Taşındı -->
                                <td class="p-4 w-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-{{ $product->id }}" type="checkbox"
                                               x-model="selectedProducts"
                                               value="{{ $product->id }}"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 product-checkbox">
                                        <label for="checkbox-{{ $product->id }}" class="sr-only">Seç</label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 px-6 text-center text-gray-600">Henüz hiç ürün eklenmemiş.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tekil Silme Onay Modalı -->
        <div
            x-show="showConfirm"
            x-transition
            style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Ürünü Sil</h2>
                <p class="mb-6">"<span x-text="deleteTitle"></span>" başlıklı ürünü silmek istediğinize emin misiniz?</p>
                <div class="flex justify-end space-x-4">
                    <button
                        @click="showConfirm = false"
                        class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300"
                    >
                        İptal
                    </button>

                    <button
                        @click="submitDelete()"
                        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
                    >
                        Sil
                    </button>
                </div>
            </div>
        </div>

        <!-- Toplu Silme Onay Modalı -->
        <div
            x-show="showBulkConfirm"
            x-transition
            style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Seçilen Ürünleri Sil</h2>
                <p class="mb-6"><span x-text="selectedProducts.length"></span> adet ürünü silmek istediğinize emin misiniz? Bu işlem geri alınamaz.</p>
                <div class="flex justify-end space-x-4">
                    <button
                        @click="showBulkConfirm = false"
                        class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300"
                    >
                        İptal
                    </button>
                    <button
                        @click="submitBulkDelete()"
                        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
                    >
                        Evet, Sil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js ve Script -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        function productList() {
            return {
                showConfirm: false,
                showBulkConfirm: false,
                deleteId: null,
                deleteTitle: '',
                selectedProducts: [],
                selectAll: false,

                // Tekil silme için modal açar
                confirmDelete(id, title) {
                    this.deleteId = id;
                    this.deleteTitle = title;
                    this.showConfirm = true;
                },

                // Tekil silme formunu gönderir
                submitDelete() {
                    this.showConfirm = false;
                    const form = document.getElementById('delete-form-' + this.deleteId);
                    if (form) form.submit();
                },

                // Toplu silme formunu gönderir
                submitBulkDelete() {
                    this.showBulkConfirm = false;
                    // Dinamik bir form oluşturarak seçili ürünleri gönderelim
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.products.bulkDelete') }}';

                    // CSRF token'ı ekle
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // HTTP metot override (DELETE)
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    // Seçilen ürün ID'lerini ekle
                    this.selectedProducts.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'product_ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }
    </script>
</x-app-layout>
