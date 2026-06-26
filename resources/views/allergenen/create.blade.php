<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('allergenen.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="Naam" :value="__('Naam')" />
                            <x-text-input id="Naam" class="mt-1 block w-full" type="text" name="Naam" :value="old('Naam')" required autofocus />
                            <x-input-error :messages="$errors->get('Naam')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="Omschrijving" :value="__('Omschrijving')" />
                            <x-text-input id="Omschrijving" class="mt-1 block w-full" type="text" name="Omschrijving" :value="old('Omschrijving')" />
                            <x-input-error :messages="$errors->get('Omschrijving')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-3">
                            <x-primary-button>
                                {{ __('Opslaan') }}
                            </x-primary-button>

                            <a href="{{ route('allergenen.index') }}" class="text-sm text-gray-600 underline hover:text-gray-900">
                                Terug naar overzicht
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
