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

                    <div class="mb-6 text-sm text-gray-700">
                        <p><strong>Naam:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>

                    <form method="POST" action="{{ route('praktijkmanagement.users.role', $user->id) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="rolename" :value="__('Gebruikersrol')" />
                            <select id="rolename" name="rolename" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->rolename }}" @selected(old('rolename', $user->rolename) === $role->rolename)>
                                        {{ $role->rolename }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('rolename')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-3">
                            <x-primary-button>
                                {{ __('Opslaan') }}
                            </x-primary-button>

                            <a href="{{ route('praktijkmanagement.index') }}" class="text-sm text-gray-600 underline hover:text-gray-900">
                                Terug naar overzicht
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
