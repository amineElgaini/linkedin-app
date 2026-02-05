<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Rechercher des professionnels</h1>
                <p class="text-gray-600 mt-2">Trouvez des talents et élargissez votre réseau professionnel</p>
            </div>

            <!-- Filtres de recherche -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <form method="GET" action="{{ route('users.search') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Recherche par nom -->
                        <div>
                            <label for="query" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="query" 
                                       id="query"
                                       value="{{ request('query') }}"
                                       placeholder="Rechercher par nom..."
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Recherche par spécialité -->
                        <div>
                            <label for="specialty" class="block text-sm font-medium text-gray-700 mb-2">
                                Spécialité
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="specialty" 
                                       id="specialty"
                                       value="{{ request('specialty') }}"
                                       placeholder="Ex: Développement Web, Marketing..."
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Bouton de recherche -->
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span>Rechercher</span>
                            </button>
                        </div>
                    </div>

                    <!-- Bouton reset -->
                    @if(request('query') || request('specialty'))
                    <div class="flex justify-end">
                        <a href="{{ route('users.search') }}" 
                           class="text-sm text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Réinitialiser les filtres</span>
                        </a>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Résultats -->
            @if($users->count() > 0)
            <div class="mb-4 flex items-center justify-between">
                <p class="text-gray-600">
                    <span class="font-semibold text-gray-900">{{ $users->total() }}</span> 
                    profil(s) trouvé(s)
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($users as $user)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group">
                    <!-- Card Header avec image de fond -->
                    <div class="h-24 bg-gradient-to-r from-blue-500 to-indigo-600 relative">
                        <div class="absolute -bottom-12 left-6">
                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3B82F6&color=fff&size=200' }}" 
                                 alt="{{ $user->name }}"
                                 class="w-24 h-24 rounded-full border-4 border-white object-cover">
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="pt-16 px-6 pb-6">
                        <!-- Nom et Titre -->
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $user->name }}</h3>
                        @if($user->profile)
                            <p class="text-sm font-medium text-blue-600 mb-1">{{ $user->profile->title ?? 'Chercheur d\'emploi' }}</p>
                            @if($user->profile->specialty)
                            <p class="text-sm text-gray-600 mb-3">{{ $user->profile->specialty }}</p>
                            @endif
                        @else
                            <p class="text-sm text-gray-600 mb-3">Chercheur d'emploi</p>
                        @endif

                        <!-- Bio (extrait) -->
                        @if($user->bio)
                        <p class="text-sm text-gray-700 mb-4 line-clamp-2">
                            {{ Str::limit($user->bio, 100) }}
                        </p>
                        @endif

                        <!-- Compétences (si disponibles) -->
                        @if($user->profile && $user->profile->skills->count() > 0)
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach($user->profile->skills->take(3) as $skill)
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-medium">
                                {{ $skill->name }}
                            </span>
                            @endforeach
                            @if($user->profile->skills->count() > 3)
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium">
                                +{{ $user->profile->skills->count() - 3 }}
                            </span>
                            @endif
                        </div>
                        @endif

                        <!-- Stats -->
                        <div class="flex items-center space-x-4 mb-4 text-xs text-gray-500">
                            @if($user->profile)
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $user->profile->experiences->count() }} expériences</span>
                            </div>
                            @endif
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Casablanca, Maroc</span>
                            </div>
                        </div>

                        <!-- Bouton d'action -->
                        <a href="{{ route('users.show', $user) }}" 
                           class="block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                            Voir le profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $users->links() }}
            </div>

            @else
            <!-- État vide -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun profil trouvé</h3>
                <p class="text-gray-600 mb-6">
                    @if(request('query') || request('specialty'))
                        Essayez de modifier vos critères de recherche
                    @else
                        Commencez une recherche pour découvrir des professionnels
                    @endif
                </p>
                @if(request('query') || request('specialty'))
                <a href="{{ route('users.search') }}" 
                   class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Nouvelle recherche</span>
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-app-layout>