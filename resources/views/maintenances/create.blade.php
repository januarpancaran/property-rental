<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajukan Permintaan Perawatan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($properties->isEmpty())
                    <p class="text-red-500">Anda tidak memiliki properti yang terikat kontrak aktif untuk diajukan permintaan perawatan.</p>
                @else
                    <form method="POST" action="{{ route('tenant.maintenances.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="property_id" :value="__('Pilih Properti')" />
                            <select id="property_id" name="property_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($properties as $property)
                                    <option value="{{ $property->id }}">{{ $property->title }} ({{ $property->address }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('property_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="title" :value="__('Judul Singkat Permintaan')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi Detail Masalah')" />
                            <textarea id="description" name="description" rows="4" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="category" :value="__('Kategori Masalah')" />
                            <select id="category" name="category" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="Plumbing">Plumbing (Air/Saluran)</option>
                                <option value="Electrical">Electrical (Listrik)</option>
                                <option value="Appliance">Appliance (Peralatan)</option>
                                <option value="HVAC">HVAC (AC/Ventilasi)</option>
                                <option value="Structural">Structural (Bangunan/Struktur)</option>
                                <option value="Other">Lain-lain</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="priority" :value="__('Tingkat Urgensi (Priority)')" />
                            <select id="priority" name="priority" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="low">Low (Rendah)</option>
                                <option value="medium">Medium (Sedang)</option>
                                <option value="high">High (Tinggi)</option>
                                <option value="urgent">Urgent (Sangat Mendesak)</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Kirim Permintaan') }}
                            </x-primary-button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>