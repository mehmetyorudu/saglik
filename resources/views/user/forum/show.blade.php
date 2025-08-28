<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forum') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                {{-- Forum Başlığı --}}
                <h3 class="text-3xl font-bold text-gray-900 mb-4">{{ $forumPost->title }}</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Yazan:
                    <span class="font-semibold">
                        {{ $forumPost->user->name }}
                        @if($forumPost->user->doctorProfile)
                            - {{ $forumPost->user->doctorProfile->specialty }}
                        @else
                            - Kullanıcı
                        @endif
                    </span>
                    - {{ $forumPost->created_at->diffForHumans() }}
                </p>

                {{-- Fotoğraf ve İçerik için kapsayıcı --}}
                <div class="flex flex-col md:flex-row mb-8 items-start">
                    @if ($forumPost->image_path)
                        <div class="mb-6 md:mb-0 md:mr-6 flex-shrink-0">
                            <img src="{{ asset('storage/' . $forumPost->image_path) }}"
                                 alt="Forum Görseli"
                                 style="width:500px; height:400px; object-fit:cover; border-radius:6px;"
                                 class="shadow-sm">
                        </div>
                    @endif
                    <div class="prose max-w-none text-gray-800">
                        <p>{{ $forumPost->content }}</p>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                {{-- Yorumlar --}}
                <h4 class="text-2xl font-bold text-gray-900 mb-6">Yorumlar ({{ $forumPost->comments->count() }})</h4>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @forelse ($forumPost->comments as $comment)
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 mb-4">
                        <div class="flex justify-between items-center text-sm text-gray-700 mb-2">
                            <span class="font-semibold">
                                {{ $comment->user->name }}
                                @if($comment->user->doctorProfile)
                                    - {{ $comment->user->doctorProfile->specialty }}
                                @else
                                    - Kullanıcı
                                @endif
                            </span>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-800">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-gray-600 mb-4">Henüz bu gönderiye yapılmış bir yorum bulunmamaktadır.</p>
                @endforelse

                {{-- Yorum Ekleme Formu --}}
                <div class="mt-8 bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Yorum Ekle</h4>
                    <form method="POST" action="{{ route('forum.comments.store', $forumPost) }}">
                        @csrf
                        <div class="mb-4">
                            <x-label for="comment_content" :value="__('Yorumunuz')" />
                            <textarea id="comment_content" name="content" rows="4" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>{{ old('content') }}</textarea>
                            @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <x-button>
                                {{ __('Yorum Yap') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
