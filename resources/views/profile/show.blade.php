<x-app-layout>
    <div class="bg-gray-50 min-h-screen">
        <!-- Messages de succès/erreur -->

        <!-- Header avec bannière -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-5xl mx-auto px-6 pb-6">
                <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-5">
                    <!-- Profile Photo -->
                    <div class="relative group">
                        <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3B82F6&color=fff&size=200' }}"
                            alt="{{ Auth::user()->name }}"
                            class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                        <button class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- User Info -->
                    <div class="mt-4 sm:mt-0 flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                        @if(Auth::user()->role === 'job_seeker' && Auth::user()->profile)
                        <p class="text-lg text-gray-700 mt-1">{{ Auth::user()->profile->title }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->profile->specialty }}</p>
                        @else
                        <p class="text-lg text-gray-700 mt-1">{{ Auth::user()->role === 'recruiter' ? 'Recruteur' : 'Chercheur d\'emploi' }}</p>
                        @endif

                        <div class="flex items-center space-x-4 mt-3 text-sm text-gray-600">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Casablanca, Maroc</span>
                            </div>
                            @if(Auth::user()->role === 'job_seeker')
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
                    <div class="mt-4 sm:mt-0 flex flex-wrap gap-2">
                        <a href="{{ route('profile.edit') }}"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Modifier le profil</span>
                        </a>
                    </div>
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
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold text-gray-900">À propos</h2>
                            <a href="{{ route('profile.edit') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            {{ Auth::user()->bio ?? 'Ajoutez une description pour vous présenter aux recruteurs et à votre réseau professionnel.' }}
                        </p>
                    </div>

                    @if(Auth::user()->role === 'job_seeker' && Auth::user()->profile)
                    <!-- Expériences -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Expérience</h2>
                            <button
                                x-data=""
                                @click="$dispatch('open-modal', 'add-experience')"
                                class="flex items-center space-x-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Ajouter</span>
                            </button>
                        </div>

                        <div class="space-y-6">
                            @forelse(Auth::user()->profile->experiences as $experience)
                            <div class="flex space-x-4 group">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $experience->position }}</h3>
                                    <p class="text-sm text-gray-600">{{ $experience->company }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ $experience->duration }}</p>
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition flex space-x-1">
                                    <button
                                        x-data=""
                                        @click="$dispatch('open-modal', 'edit-experience-{{ $experience->id }}')"
                                        class="p-2 hover:bg-gray-100 rounded-lg transition h-fit">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('experiences.destroy', $experience) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 hover:bg-red-50 rounded-lg transition h-fit">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal d'édition pour cette expérience -->
                            <x-modal name="edit-experience-{{ $experience->id }}" focusable>
                                <form method="POST" action="{{ route('experiences.update', $experience) }}" class="p-6">
                                    @csrf
                                    @method('PUT')

                                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Modifier l'expérience</h2>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Poste *</label>
                                            <input type="text" name="position" value="{{ $experience->position }}" required
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise *</label>
                                            <input type="text" name="company" value="{{ $experience->company }}" required
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Durée *</label>
                                            <input type="text" name="duration" value="{{ $experience->duration }}" placeholder="Ex: 2 ans, 6 mois..." required
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end space-x-3 mt-6">
                                        <button type="button" @click="$dispatch('close')"
                                            class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                            Annuler
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                                            Enregistrer
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                            @empty
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500 mb-4">Aucune expérience ajoutée</p>
                                <button
                                    x-data=""
                                    @click="$dispatch('open-modal', 'add-experience')"
                                    class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Ajouter votre première expérience →
                                </button>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Formation -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Formation</h2>
                            <button
                                x-data=""
                                @click="$dispatch('open-modal', 'add-education')"
                                class="flex items-center space-x-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Ajouter</span>
                            </button>
                        </div>

                        <div class="space-y-6">
                            @forelse(Auth::user()->profile->educations as $education)
                            <div class="flex space-x-4 group">
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
                                <div class="opacity-0 group-hover:opacity-100 transition flex space-x-1">
                                    <button
                                        x-data=""
                                        @click="$dispatch('open-modal', 'edit-education-{{ $education->id }}')"
                                        class="p-2 hover:bg-gray-100 rounded-lg transition h-fit">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('educations.destroy', $education) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 hover:bg-red-50 rounded-lg transition h-fit">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal d'édition pour cette formation -->
                            <x-modal name="edit-education-{{ $education->id }}" focusable>
                                <form method="POST" action="{{ route('educations.update', $education) }}" class="p-6">
                                    @csrf
                                    @method('PUT')

                                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Modifier la formation</h2>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Diplôme *</label>
                                            <input type="text" name="degree" value="{{ $education->degree }}" required
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">École/Université *</label>
                                            <input type="text" name="school" value="{{ $education->school }}" required
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Année d'obtention *</label>
                                            <input type="number" name="year_obtained" value="{{ $education->year_obtained }}" min="1950" max="{{ date('Y') }}" required
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end space-x-3 mt-6">
                                        <button type="button" @click="$dispatch('close')"
                                            class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                            Annuler
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                                            Enregistrer
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                            @empty
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p class="text-gray-500 mb-4">Aucune formation ajoutée</p>
                                <button
                                    x-data=""
                                    @click="$dispatch('open-modal', 'add-education')"
                                    class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Ajouter votre première formation →
                                </button>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Compétences -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Compétences</h2>
                            <button
                                x-data=""
                                @click="$dispatch('open-modal', 'add-skill')"
                                class="flex items-center space-x-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Ajouter</span>
                            </button>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @forelse(Auth::user()->profile->skills as $skill)
                            <div class="group relative">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium hover:bg-blue-100 transition cursor-pointer inline-flex items-center">
                                    {{ $skill->name }}
                                    <form action="{{ route('skills.detach', $skill) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Retirer cette compétence ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="opacity-0 group-hover:opacity-100 transition">
                                            <svg class="w-4 h-4 text-blue-700 hover:text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </span>
                            </div>
                            @empty
                            <div class="text-center w-full py-8">
                                <p class="text-gray-500 mb-4">Aucune compétence ajoutée</p>
                                <button
                                    x-data=""
                                    @click="$dispatch('open-modal', 'add-skill')"
                                    class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Ajouter vos compétences →
                                </button>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Stats Card -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Statistiques du profil</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Vues du profil</span>
                                <span class="font-semibold text-gray-900">{{ rand(50, 500) }}</span>
                            </div>
                            @if(Auth::user()->role === 'job_seeker')
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Candidatures</span>
                                <span class="font-semibold text-gray-900">{{ Auth::user()->applications()->count() }}</span>
                            </div>
                            @else
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Offres publiées</span>
                                <span class="font-semibold text-gray-900">{{ Auth::user()->jobOffers()->count() }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Actions rapides</h3>
                        <div class="space-y-2">
                            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Modifier le profil</span>
                            </a>

                            @if(Auth::user()->role === 'job_seeker')
                            <a href="{{ route('job-offers.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Rechercher un emploi</span>
                            </a>
                            @else
                            <a href="{{ route('job-offers.create') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Publier une offre</span>
                            </a>
                            @endif

                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Paramètres</span>
                            </a>
                        </div>
                    </div>

                    <!-- Recommendation -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-6">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Améliorez votre profil</h4>
                                <p class="text-sm text-gray-600 mb-3">Complétez votre profil pour augmenter vos chances d'être découvert par les recruteurs.</p>
                                <button class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                    Commencer →
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour ajouter une expérience -->
    <x-modal name="add-experience" focusable>
        <form method="POST" action="{{ route('experiences.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold text-gray-900 mb-6">Ajouter une expérience</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Poste *</label>
                    <input type="text" name="position" required placeholder="Ex: Développeur Full Stack"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise *</label>
                    <input type="text" name="company" required placeholder="Ex: Google, Microsoft..."
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Durée *</label>
                    <input type="text" name="duration" required placeholder="Ex: 2 ans, 6 mois..."
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Indiquez la durée totale de cette expérience</p>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6">
                <button type="button" @click="$dispatch('close')"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    Ajouter
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal pour ajouter une formation -->
    <x-modal name="add-education" focusable>
        <form method="POST" action="{{ route('educations.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold text-gray-900 mb-6">Ajouter une formation</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Diplôme *</label>
                    <input type="text" name="degree" required placeholder="Ex: Master en Informatique"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">École/Université *</label>
                    <input type="text" name="school" required placeholder="Ex: Université Mohammed V"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Année d'obtention *</label>
                    <input type="number" name="year_obtained" required min="1950" max="{{ date('Y') }}" placeholder="{{ date('Y') }}"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6">
                <button type="button" @click="$dispatch('close')"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    Ajouter
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal pour ajouter une compétence -->
    <x-modal name="add-skill" focusable>
        <form method="POST" action="{{ route('skills.attach') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-semibold text-gray-900 mb-6">Ajouter une compétence</h2>

            <div class="space-y-4">
                <div>
                    <!-- <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la compétence *</label> -->
                    <!-- <input type="text" name="skill_name" required placeholder="Ex: Laravel, JavaScript, Gestion de projet..."
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"> -->
                    <div
                        x-data="{
        query: '',
        results: [],
        selected: null,
        loading: false,

        async search() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }

            this.loading = true;

            const res = await fetch(
                `{{ route('skills.search') }}?query=${encodeURIComponent(this.query)}`
            );

            this.results = await res.json();
            this.loading = false;
        },

        select(skill) {
            this.query = skill.name;
            this.selected = skill;
            this.results = [];
        }
    }"
                        class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nom de la compétence *
                        </label>

                        <input
                            type="text"
                            x-model="query"
                            @input.debounce.300ms="search"
                            placeholder="Ex: Laravel, JavaScript..."
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            autocomplete="off">

                        <!-- Hidden value sent to backend -->
                        <input type="hidden" name="skill_name" :value="query">

                        <!-- Dropdown -->
                        <div
                            x-show="results.length || loading"
                            x-transition
                            class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg">
                            <div x-show="loading" class="px-4 py-2 text-sm text-gray-500">
                                Searching...
                            </div>

                            <template x-for="skill in results" :key="skill.id">
                                <button
                                    type="button"
                                    @click="select(skill)"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100"
                                    x-text="skill.name"></button>
                            </template>

                            <div
                                x-show="!loading && results.length === 0 && query.length >= 2"
                                class="px-4 py-2 text-sm text-gray-500">
                                Press enter to add "<span x-text="query"></span>"
                            </div>
                        </div>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">Ajoutez une compétence technique ou soft skill</p>
                </div>

                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Conseil</p>
                            <p>Ajoutez des compétences pertinentes pour votre domaine. Soyez spécifique!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6">
                <button type="button" @click="$dispatch('close')"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    Ajouter
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>