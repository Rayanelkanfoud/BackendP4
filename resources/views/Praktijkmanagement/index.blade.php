<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ $title }}
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('status'))
                        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-medium text-gray-900">
                        Gebruikers
                    </h3>

                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Naam</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Rol</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actie</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $user->rolename }}</td>
                                        <td class="px-4 py-3 text-right text-sm">
                                            @if (auth()->id() !== $user->id)
                                                <form method="POST" action="{{ route('praktijkmanagement.users.destroy', $user) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                                        onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')"
                                                    >
                                                        Verwijderen
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-sm text-gray-400">Eigen account</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
