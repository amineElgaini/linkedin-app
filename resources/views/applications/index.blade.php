<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Candidatures reçues</h2>

                    @if($applications->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">Aucune candidature reçue pour le moment.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidat</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Offre</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($applications as $application)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($application->user->profile_photo)
                                                        <!-- <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ $application->user->profile_photo }}" alt="{{ $application->user->name }}"> -->
                                                         <img class="h-10 w-10 rounded-full object-cover mr-3" 
    src="{{ $application->user->profile_photo 
        ? asset('storage/' . $application->user->profile_photo) 
        : 'https://ui-avatars.com/api/?name=' . urlencode($application->user->name) . '&background=3B82F6&color=fff' }}" 
    alt="{{ $application->user->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold mr-3">
                                                            {{ substr($application->user->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a href="{{ route('users.show', $application->user) }}" class="hover:underline">
                                                                {{ $application->user->name }}
                                                            </a>
                                                        </div>
                                                        <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $application->jobOffer->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $application->jobOffer->company_name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $application->created_at->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($application->status === 'accepted') bg-green-100 text-green-800 
                                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800 
                                                    @elseif($application->status === 'pending') bg-yellow-100 text-yellow-800 
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <form method="POST" action="{{ route('applications.update-status', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Accepter cette candidature ?')">Accepter</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('applications.update-status', $application) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Refuser cette candidature ?')">Refuser</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $applications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
