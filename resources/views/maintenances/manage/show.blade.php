<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Permintaan: ') . $maintenance->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-6 text-gray-900 dark:text-gray-100">

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('warning') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3 class="text-2xl font-bold border-b border-gray-200 dark:border-gray-700 pb-2">Detail Permintaan</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Properti:</p>
                        <p class="text-lg font-semibold">{{ $maintenance->property->title }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Diajukan Oleh:</p>
                        <p class="text-lg">{{ $maintenance->user->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status:</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold"
                            style="background-color: {{ match ($maintenance->status_color) {'red' => 'rgba(252, 165, 165, 0.5)','blue' => 'rgba(147, 197, 253, 0.5)','yellow' => 'rgba(250, 240, 153, 0.5)','green' => 'rgba(167, 243, 208, 0.5)',default => 'rgba(209, 213, 219, 0.5)'} }};
                                     color: {{ match ($maintenance->status_color) {'red' => 'rgb(185, 28, 28)','blue' => 'rgb(29, 78, 216)','yellow' => 'rgb(159, 90, 31)','green' => 'rgb(4, 120, 87)',default => 'rgb(75, 85, 99)'} }};">
                            {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Prioritas:</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold"
                            style="background-color: {{ match ($maintenance->priority_color) {'red' => 'rgba(252, 165, 165, 0.5)','orange' => 'rgba(251, 191, 36, 0.5)','yellow' => 'rgba(250, 240, 153, 0.5)','green' => 'rgba(167, 243, 208, 0.5)',default => 'rgba(209, 213, 219, 0.5)'} }};
                                     color: {{ match ($maintenance->priority_color) {'red' => 'rgb(185, 28, 28)','orange' => 'rgb(180, 83, 9)','yellow' => 'rgb(159, 90, 31)','green' => 'rgb(4, 120, 87)',default => 'rgb(75, 85, 99)'} }};">
                            {{ ucfirst($maintenance->priority) }}
                        </span>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi Detail:</p>
                    <p class="whitespace-pre-wrap">{{ $maintenance->description }}</p>
                </div>


                <h3 class="text-xl font-bold border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">Manajemen &
                    Penugasan</h3>

                <form method="POST" action="{{ route('manage.maintenances.update', $maintenance) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="scheduled_date" :value="__('Jadwal Perbaikan')" />
                            <x-text-input id="scheduled_date" class="block mt-1 w-full" type="date"
                                name="scheduled_date" :value="old('scheduled_date', $maintenance->scheduled_date?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('scheduled_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="assigned_to" :value="__('Ditugaskan Kepada (Nama Teknisi)')" />
                            <x-text-input id="assigned_to" class="block mt-1 w-full" type="text" name="assigned_to"
                                :value="old('assigned_to', $maintenance->assigned_to)" />
                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="estimated_cost" :value="__('Perkiraan Biaya (Rp)')" />
                            <x-text-input id="estimated_cost" class="block mt-1 w-full" type="number" step="1000"
                                name="estimated_cost" :value="old('estimated_cost', $maintenance->estimated_cost)" />
                            <x-input-error :messages="$errors->get('estimated_cost')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Ubah Status')" />
                            <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($maintenance->status == $status)>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Update Manajemen') }}
                        </x-primary-button>
                    </div>
                </form>

                <div class="flex justify-start space-x-4 border-t border-gray-200 dark:border-gray-700 pt-4 mt-6">
                    {{-- @can('complete_maintenance') --}}
                        @if (!$maintenance->isCompleted() && !$maintenance->isCancelled())
                            <form method="POST" action="{{ route('manage.maintenances.complete', $maintenance) }}">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin menandai permintaan ini sebagai SELESAI?')"
                                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                    Tandai Selesai
                                </button>
                            </form>
                        @endif
                    {{-- @endcan --}}

                    {{-- @can('complete_maintenance') --}}
                        @if (!$maintenance->isCompleted() && !$maintenance->isCancelled())
                            <form method="POST" action="{{ route('manage.maintenances.cancel', $maintenance) }}">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin MEMBATALKAN permintaan ini?')"
                                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    Batalkan Permintaan
                                </button>
                            </form>
                        @endif
                    {{-- @endcan --}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
