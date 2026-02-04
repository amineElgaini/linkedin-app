<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-4 mb-2">
                    <a href="{{ route('profile.show') }}" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">Modifier le profil</h1>
                </div>
                <p class="text-gray-600">Mettez à jour vos informations professionnelles</p>
            </div>

            @if (session('status') === 'profile-updated')
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center space-x-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-green-800 font-medium">Profil mis à jour avec succès!</span>
            </div>
            @endif

            <div class="space-y-6">
                <!-- Informations de base -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Informations personnelles</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Photo de profil -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                                <div class="flex items-center space-x-6">
                                    <img id="preview"
                                        src="{{ Auth::user()->profile_photo 
            ? asset('storage/' . Auth::user()->profile_photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3B82F6&color=fff&size=200' }}"
                                        alt="Photo de profil"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-gray-100">

                                    <div>
                                        <input type="file"
                                            name="profile_photo"
                                            id="profile_photo"
                                            accept="image/*"
                                            class="hidden"
                                            onchange="previewImage(this)">
                                        <label for="profile_photo" class="cursor-pointer px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition inline-block">
                                            Choisir une photo
                                        </label>
                                        <p class="mt-2 text-xs text-gray-500">JPG, PNG ou GIF. Max 2MB.</p>
                                    </div>
                                </div>
                                @error('profile_photo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                                <input type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', Auth::user()->name) }}"
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Biographie
                                    <span class="text-gray-500 font-normal">(facultatif)</span>
                                </label>
                                <textarea name="bio"
                                    id="bio"
                                    rows="4"
                                    placeholder="Parlez de vous, de votre parcours et de vos aspirations professionnelles..."
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('bio', Auth::user()->bio) }}</textarea>
                                <p class="mt-2 text-xs text-gray-500">Maximum 1000 caractères</p>
                                @error('bio')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if(Auth::user()->role === 'job_seeker')
                            <!-- Titre professionnel -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre professionnel</label>
                                <input type="text"
                                    name="title"
                                    id="title"
                                    value="{{ old('title', Auth::user()->profile->title ?? '') }}"
                                    placeholder="Ex: Développeur Full Stack Senior"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Spécialité -->
                            <div>
                                <label for="specialty" class="block text-sm font-medium text-gray-700 mb-2">Spécialité</label>
                                <input type="text"
                                    name="specialty"
                                    id="specialty"
                                    value="{{ old('specialty', Auth::user()->profile->specialty ?? '') }}"
                                    placeholder="Ex: Développement Web, Data Science, Marketing Digital..."
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('specialty')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Boutons d'action -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <a href="{{ route('profile.show') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                    Annuler
                                </a>
                                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Enregistrer les modifications</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Changer le mot de passe -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Sécurité</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                                <input type="password"
                                    name="current_password"
                                    id="current_password"
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('current_password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                                <input type="password"
                                    name="password"
                                    id="password"
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                                <input type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                @error('password_confirmation', 'updatePassword')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-600">Le mot de passe doit contenir au moins 8 caractères</p>
                                <button type="submit" class="px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-medium transition">
                                    Mettre à jour le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Supprimer le compte -->
                <div class="bg-white rounded-lg shadow-sm border border-red-200">
                    <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                        <h2 class="text-lg font-semibold text-red-900">Zone de danger</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Supprimer le compte</h3>
                                <p class="text-sm text-gray-600">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.</p>
                            </div>
                            <button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition text-sm whitespace-nowrap">
                                Supprimer le compte
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                Êtes-vous sûr de vouloir supprimer votre compte ?
            </h2>

            <p class="text-sm text-gray-600 mb-6">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.
            </p>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                <input type="password"
                    name="password"
                    id="password"
                    placeholder="Entrez votre mot de passe"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                @error('password', 'userDeletion')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-3">
                <button type="button"
                    x-on:click="$dispatch('close')"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
                    Supprimer le compte
                </button>
            </div>
        </form>
    </x-modal>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>