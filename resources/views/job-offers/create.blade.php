<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Créer une offre d'emploi</h2>

                    <form action="{{ route('job-offers.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Job Title -->
                        <div>
                            <x-input-label for="title" value="Intitulé du poste" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Company Name -->
                        <div>
                            <x-input-label for="company_name" value="Nom de l'entreprise" />
                            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                        </div>

                        <!-- Contract Type -->
                        <div>
                            <x-input-label for="contract_type" value="Type de contrat" />
                            <select id="contract_type" name="contract_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Stage">Stage</option>
                                <option value="Alternance">Alternance</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('contract_type')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" value="Description du poste" />
                            <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Image URL -->
                        <div>
                            <x-input-label for="image" value="URL de l'image (Optionnel)" />
                            <x-text-input id="image" name="image" type="url" class="mt-1 block w-full" :value="old('image')" placeholder="https://example.com/image.jpg" />
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('job-offers.index') }}" class="text-gray-600 hover:text-gray-900">Annuler</a>
                            <x-primary-button>
                                Publier l'offre
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
