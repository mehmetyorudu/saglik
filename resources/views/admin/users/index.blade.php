<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Tüm Kullanıcılar') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="userList()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Sistemdeki Tüm Kullanıcılar</h3>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('warning') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                @if (session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('info') }}</span>
                    </div>
                @endif

                <div class="mb-6">
                    <form action="{{ route('admin.users') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0">
                        <input
                            type="text"
                            name="search"
                            placeholder="İsim veya e-posta ile ara..."
                            value="{{ request('search') }}"
                            class="rounded-md shadow-sm w-full sm:w-auto mr-4"
                        >

                        <select name="role" class="rounded-md shadow-sm w-full sm:w-auto mr-4">
                            <option value="" @if(request('role') == '') selected @endif>Tüm Kullanıcılar</option>
                            <option value="admin" @if(request('role') == 'admin') selected @endif>Yöneticiler</option>
                            <option value="doctor" @if(request('role') == 'doctor') selected @endif>Doktorlar</option>
                            <option value="regular" @if(request('role') == 'regular') selected @endif>Danışanlar</option>
                        </select>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-full sm:w-auto">
                            Filtrele
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">Ad Soyad</th>
                            <th scope="col" class="py-3 px-6">E-posta</th>
                            <th scope="col" class="py-3 px-6">Yaş</th>
                            <th scope="col" class="py-3 px-6">Boy (cm)</th>
                            <th scope="col" class="py-3 px-6">Kilo (kg)</th>
                            <th scope="col" class="py-3 px-6">Bel Çevresi (cm)</th>
                            <th scope="col" class="py-3 px-6">Yönetici Mi?</th>
                            <th scope="col" class="py-3 px-6">Doktor Mu?</th>
                            <th scope="col" class="py-3 px-6">İşlemler</th> </tr>
                        </thead>
                        <tbody>
                        @forelse ($users as $user)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $user->name }}
                                </th>
                                <td class="py-4 px-6">
                                    {{ $user->email }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $user->age ?? '-' }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $user->height ? $user->height . ' cm' : '-' }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $user->weight ? $user->weight . ' kg' : '-' }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $user->waist_circumference ? $user->waist_circumference . ' cm' : '-' }}
                                </td>
                                <td class="py-4 px-6">
                                    @if ($user->is_admin)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Evet</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Hayır</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if ($user->doctorProfile)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Evet</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Hayır</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="font-medium text-blue-600 hover:underline">Düzenle</a>
                                        <form
                                            id="delete-form-{{ $user->id }}"
                                            action="{{ route('admin.users.destroy', $user) }}"
                                            method="POST"
                                            @submit.prevent
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="button"
                                                @click="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                class="font-medium text-red-600 hover:underline"
                                            >
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-4 px-6 text-center text-gray-600">
                                    Henüz kayıtlı kullanıcı bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div
            x-show="showConfirm"
            x-transition
            style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Kullanıcıyı Sil</h2>
                <p class="mb-6">"<span x-text="deleteName"></span>" adlı kullanıcıyı silmek istediğinize emin misiniz?</p>
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
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        function userList() {
            return {
                showConfirm: false,
                deleteId: null,
                deleteName: '',

                confirmDelete(id, name) {
                    this.deleteId = id;
                    this.deleteName = name;
                    this.showConfirm = true;
                },

                submitDelete() {
                    this.showConfirm = false;
                    const form = document.getElementById('delete-form-' + this.deleteId);
                    if (form) form.submit();
                }
            }
        }
    </script>
</x-app-layout>
