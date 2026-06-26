<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
                <meta http-equiv="refresh" content="3;url={{ route('allergenen.index') }}">
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
                <meta http-equiv="refresh" content="3;url={{ route('allergenen.index') }}">
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            Alle allergenen
                        </h3>

                        <a href="{{ route('allergenen.create') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                            Nieuw allergeen
                        </a>
                    </div>

                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Id</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Naam</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Omschrijving</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Wijzigen</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Verwijderen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($allergenen as $allergeen)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $allergeen->Id }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $allergeen->Naam }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $allergeen->Omschrijving }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <form method="POST" action="{{ route('allergenen.edit', $allergeen->Id) }}">
                                                @csrf
                                                @method('GET')

                                                <button type="submit" class="rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                                                    Wijzigen
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm">
                                            <form method="POST" action="{{ route('allergenen.destroy', $allergeen->Id) }}" onsubmit="return confirm('Weet je zeker dat je dit allergeen wilt verwijderen?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                                    Verwijderen
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-sm text-gray-500">
                                            Geen allergenen beschikbaar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
