<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold text-gray-900 mb-6">Mes relations</h1>

            <!-- Friend Requests -->
            @if($friendRequests->isNotEmpty())
            <div class="mb-10">
                <h2 class="text-xl font-semibold mb-4">Demandes d’amitié</h2>

                <div class="space-y-4">
                    @foreach($friendRequests as $request)
                    <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow border">
                        <div class="flex items-center space-x-4">
                            <img class="w-12 h-12 rounded-full"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($request->sender->name) }}"
                                 alt="{{ $request->sender->name }}">
                            <div>
                                <p class="font-medium">{{ $request->sender->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $request->sender->profile->specialty ?? 'Aucune spécialité' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('friends.accept', $request) }}">
                                @csrf
                                <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Accepter
                                </button>
                            </form>

                            <form method="POST" action="{{ route('friends.reject', $request) }}">
                                @csrf
                                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Refuser
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Friends -->
            <h2 class="text-xl font-semibold mb-4">Amis</h2>

            @if($friends->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($friends as $friendship)
                    @php
                        $friend = $friendship->user_id === auth()->id()
                            ? $friendship->receiver
                            : $friendship->sender;
                    @endphp

                    <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow border">
                        <div class="flex items-center space-x-4">
                            <img class="w-12 h-12 rounded-full"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($friend->name) }}"
                                 alt="{{ $friend->name }}">
                            <div>
                                <p class="font-medium">{{ $friend->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $friend->profile->specialty ?? 'Aucune spécialité' }}
                                </p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('friends.remove', $friendship) }}">
                            @csrf
                            @method('DELETE')
                            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            @else
                <p class="text-gray-600">Vous n’avez pas encore d’amis.</p>
            @endif
        </div>
    </div>
</x-app-layout>
