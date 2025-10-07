<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ $property ? route('properties.show', $property) : route('properties.index') }}"
                    class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                    ← Back
                </a>
            </div>

            @if ($property)
                <!-- Property Info Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex gap-4">
                            <div class="w-32 h-32 flex-shrink-0">
                                @if ($property->featuredPhoto)
                                    <img src="{{ $property->featuredPhoto->url }}" alt="{{ $property->title }}"
                                        class="w-full h-full object-cover rounded">
                                @else
                                    <div class="w-full h-full bg-gray-200 dark:bg-gray-700 rounded"></div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $property->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-2">
                                    {{ $property->city }}, {{ $property->state }}
                                </p>
                                <p class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                    Rp {{ number_format($property->rent_amount, 0, ',', '.') }}/month
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    ≈ Rp {{ number_format($property->rent_amount / 30, 0, ',', '.') }}/night
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Form -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">

                            <div class="mb-4">
                                <label for="check_in_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Check-in Date
                                </label>
                                <input type="date" name="check_in_date" id="check_in_date"
                                    value="{{ old('check_in_date') }}" min="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                @error('check_in_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="check_out_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Check-out Date
                                </label>
                                <input type="date" name="check_out_date" id="check_out_date"
                                    value="{{ old('check_out_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                @error('check_out_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('dates')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Availability Check Result -->
                            <div id="availabilityResult" class="mb-4 hidden">
                                <div class="p-4 rounded-lg" id="availabilityCard">
                                    <p class="font-semibold mb-2" id="availabilityMessage"></p>
                                    <div id="priceBreakdown" class="text-sm space-y-1"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notes"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Additional Notes (Optional)
                                </label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Any special requests or information...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('properties.show', $property) }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Cancel
                                </a>
                                <button type="button" id="checkAvailabilityBtn"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Check Availability
                                </button>
                                <button type="submit" id="submitBtn"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    disabled>
                                    Book Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Please select a property first.</p>
                        <a href="{{ route('properties.index') }}"
                            class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                            Browse Properties
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($property)
        <script>
            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');
            const checkBtn = document.getElementById('checkAvailabilityBtn');
            const submitBtn = document.getElementById('submitBtn');
            const resultDiv = document.getElementById('availabilityResult');
            const availabilityCard = document.getElementById('availabilityCard');
            const availabilityMessage = document.getElementById('availabilityMessage');
            const priceBreakdown = document.getElementById('priceBreakdown');

            checkBtn.addEventListener('click', function() {
                const checkIn = checkInInput.value;
                const checkOut = checkOutInput.value;

                if (!checkIn || !checkOut) {
                    alert('Please select both check-in and check-out dates');
                    return;
                }

                fetch('{{ route('bookings.check-availability') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            property_id: {{ $property->id }},
                            check_in_date: checkIn,
                            check_out_date: checkOut
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        resultDiv.classList.remove('hidden');
                        availabilityMessage.textContent = data.message;

                        if (data.available) {
                            availabilityCard.className =
                                'p-4 rounded-lg bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700';
                            availabilityMessage.className = 'font-semibold mb-2 text-green-800 dark:text-green-200';
                            priceBreakdown.innerHTML = `
                        <p class="text-green-700 dark:text-green-300">Nights: ${data.nights}</p>
                        <p class="text-green-700 dark:text-green-300">Daily Rate: Rp ${data.daily_rate.toLocaleString('id-ID')}</p>
                        <p class="text-green-700 dark:text-green-300 font-bold text-lg">Total: ${data.formatted_total}</p>
                    `;
                            submitBtn.disabled = false;
                        } else {
                            availabilityCard.className =
                                'p-4 rounded-lg bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700';
                            availabilityMessage.className = 'font-semibold mb-2 text-red-800 dark:text-red-200';
                            priceBreakdown.innerHTML = '';
                            submitBtn.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error checking availability');
                    });
            });

            // Update min date for check-out when check-in changes
            checkInInput.addEventListener('change', function() {
                const checkInDate = new Date(this.value);
                checkInDate.setDate(checkInDate.getDate() + 1);
                checkOutInput.min = checkInDate.toISOString().split('T')[0];
                submitBtn.disabled = true;
                resultDiv.classList.add('hidden');
            });

            checkOutInput.addEventListener('change', function() {
                submitBtn.disabled = true;
                resultDiv.classList.add('hidden');
            });
        </script>
    @endif
</x-app-layout>
