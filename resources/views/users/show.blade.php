<x-app-layout>
    <div class="bg-gray-50 min-h-screen">
        <!-- Header avec bannière -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-5xl mx-auto px-6 pb-6">
                <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-5">
                    <!-- Profile Photo -->
                    <div class="relative">
                        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3B82F6&color=fff&size=200' }}"
                            alt="{{ $user->name }}"
                            class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                    </div>

                    <!-- User Info -->
                    <div class="mt-4 sm:mt-0 flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        @if($user->role === 'job_seeker' && $user->profile)
                        <p class="text-lg text-gray-700 mt-1">{{ $user->profile->title }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $user->profile->specialty }}</p>
                        @else
                        <p class="text-lg text-gray-700 mt-1">{{ $user->role === 'recruiter' ? 'Recruteur' : 'Chercheur d\'emploi' }}</p>
                        @endif

                        <div class="flex items-center space-x-4 mt-3 text-sm text-gray-600">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Casablanca, Maroc</span>
                            </div>
                            @if($user->role === 'job_seeker')
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>500+ relations</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if(Auth::user()->role === 'job_seeker' && $user->role === 'job_seeker')
                    <div class="mt-4 sm:mt-0 flex flex-wrap gap-2">
                        @if(Auth::user()->isFriendWith($user))
                        <!-- Déjà amis -->
                        <button disabled
                            class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg font-medium cursor-not-allowed flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Amis</span>
                        </button>
                        @elseif(Auth::user()->hasPendingFriendRequestWith($user))
                        <!-- Demande en attente -->
                        <button disabled
                            class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg font-medium cursor-not-allowed flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>En attente</span>
                        </button>
                        @else
                        <!-- Envoyer une demande d'amitié -->
                        <form action="{{ route('friends.request', $user) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                <span>Ajouter aux relations</span>
                            </button>
                        </form>
                        @endif

                        <button
                            class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg font-medium transition flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Message</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- À propos -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">À propos</h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $user->bio ?? 'Aucune description disponible.' }}
                        </p>
                    </div>

                    @if($user->role === 'job_seeker' && $user->profile)
                    <!-- Expériences -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Expérience</h2>

                        <div class="space-y-6">
                            @forelse($user->profile->experiences as $experience)
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $experience->position }}</h3>
                                    <p class="text-sm text-gray-600">{{ $experience->company }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ $experience->duration }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500">Aucune expérience renseignée</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Formation -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Formation</h2>

                        <div class="space-y-6">
                            @forelse($user->profile->educations as $education)
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-100 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $education->school }}</h3>
                                    <p class="text-sm text-gray-600">{{ $education->degree }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ $education->year_obtained }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p class="text-gray-500">Aucune formation renseignée</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Compétences -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Compétences</h2>

                        <div class="flex flex-wrap gap-2">
                            @forelse($user->profile->skills as $skill)
                            <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium">
                                {{ $skill->name }}
                            </span>
                            @empty
                            <div class="text-center w-full py-8">
                                <p class="text-gray-500">Aucune compétence renseignée</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Contact Card -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Informations de contact</h3>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3 text-sm">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-700">{{ $user->email }}</span>
                            </div>
                            <div class="flex items-center space-x-3 text-sm">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-gray-700">Casablanca, Maroc</span>
                            </div>
                        </div>
                    </div>

                    @if($user->role === 'job_seeker' && $user->profile)
                    <!-- Stats Card -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Statistiques</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Expériences</span>
                                <span class="font-semibold text-gray-900">{{ $user->profile->experiences->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Formations</span>
                                <span class="font-semibold text-gray-900">{{ $user->profile->educations->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Compétences</span>
                                <span class="font-semibold text-gray-900">{{ $user->profile->skills->count() }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Retour à la recherche -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-6">
                        <a href="{{ route('users.search') }}" class="flex items-center space-x-3 text-blue-600 hover:text-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span class="font-medium">Retour à la recherche</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>