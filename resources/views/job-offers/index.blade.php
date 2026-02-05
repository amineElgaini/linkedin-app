<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Offres d'emploi</h1>
                <p class="text-gray-600 mt-2">Découvrez les opportunités et postulez directement en ligne</p>
            </div>

            <!-- Filtres de recherche -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <form method="GET" action="{{ route('job-offers.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Recherche par titre -->
                        <div>
                            <label for="query" class="block text-sm font-medium text-gray-700 mb-2">Poste</label>
                            <input type="text" name="query" id="query" value="{{ request('query') }}"
                                placeholder="Ex: Développeur, Designer..."
                                class="block w-full pl-3 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Recherche par entreprise -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Entreprise</label>
                            <input type="text" name="company" id="company" value="{{ request('company') }}"
                                placeholder="Ex: Google, Microsoft..."
                                class="block w-full pl-3 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Bouton de recherche -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                                Rechercher
                            </button>
                        </div>
                    </div>

                    <!-- Bouton reset -->
                    @if(request('query') || request('company'))
                    <div class="flex justify-end mt-2">
                        <a href="{{ route('job-offers.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                            Réinitialiser les filtres
                        </a>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Résultats -->
            @if($jobOffers->count() > 0)
            <div class="space-y-6">
                @foreach($jobOffers as $offer)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition p-6">
                    <!-- Job Header -->
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $offer->title }}</h2>
                        <p class="text-sm font-medium text-blue-600">{{ $offer->company }}</p>
                        @if($offer->location)
                        <p class="text-sm text-gray-600">{{ $offer->location }}</p>
                        @endif
                    </div>

                    <!-- Job Description -->
                    <div class="mb-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $offer->description }}</p>
                    </div>

                    <!-- Job Metadata -->
                    <div class="flex flex-wrap gap-4 text-xs text-gray-500 mb-4">
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8a6 6 0 11-12 0 6 6 0 0112 0zM12 14v4m-4-4v4m8-4v4"></path>
                            </svg>
                            <span>Posté le {{ $offer->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 10h8l3-10h4"></path>
                            </svg>
                            <span>{{ $offer->applications->count() }} candidature(s)</span>
                        </div>
                    </div>

                    <!-- Apply Button -->
                    @auth
                    @if(Auth::user()->role === 'job_seeker')
                    <form action="{{ route('applications.apply', $offer) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 rounded-lg text-white font-medium transition
                {{ $offer->applications->isNotEmpty() ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }}"
                            {{ $offer->applications->isNotEmpty() ? 'disabled' : '' }}>
                            {{ $offer->applications->isNotEmpty() ? 'Déjà postulé' : 'Postuler' }}
                        </button>
                    </form>
                    @endif
                    @endauth

                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $jobOffers->links() }}
            </div>

            @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune offre trouvée</h3>
                <p class="text-gray-600 mb-6">
                    Essayez de modifier vos critères de recherche
                </p>
                <a href="{{ route('job-offers.index') }}"
                    class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    Nouvelle recherche
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>