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
                    class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
            </div>

            @if ($property)
                <!-- Property Info Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex gap-4">
                            <div class="w-32 h-32 flex-shrink-0">
                                @if ($property->featuredPhoto)
                                    <img src="{{ $property->featuredPhoto->url }}" alt="{{ $property->title }}"
                                        class="w-full h-full object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg flex items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $property->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-2">
                                    {{ $property->city }}, {{ $property->state }}
                                </p>
                                <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
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
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
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
                                    value="{{ old('check_in_date', request('check_in')) }}" min="{{ date('Y-m-d') }}"
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
                                    value="{{ old('check_out_date', request('check_out')) }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                @error('check_out_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('dates')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price Calculation Display -->
                            <div id="priceDisplay" class="mb-4 hidden">
                                <div
                                    class="p-4 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-700">
                                    <div class="text-sm space-y-1 text-indigo-800 dark:text-indigo-200">
                                        <p>Number of Nights: <span id="nightsCount" class="font-semibold"></span></p>
                                        <p>Daily Rate: <span id="dailyRate" class="font-semibold">Rp
                                                {{ number_format($property->rent_amount / 30, 0, ',', '.') }}</span>
                                        </p>
                                        <p class="text-lg font-bold pt-2 border-t border-indigo-200 dark:border-indigo-700">
                                            Total Amount: <span id="totalAmount"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
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
                                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                                    Cancel
                                </a>
                                <button type="submit" id="submitBtn"
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Book Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Please select a property first.</p>
                        <a href="{{ route('properties.index') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Browse Properties
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($property)
        <script>
            const propertyId = {{ $property->id }};
            const rentAmount = {{ $property->rent_amount }};
            const dailyRate = Math.round(rentAmount / 30);

            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');
            const submitBtn = document.getElementById('submitBtn');
            const priceDisplay = document.getElementById('priceDisplay');
            const nightsCount = document.getElementById('nightsCount');
            const totalAmount = document.getElementById('totalAmount');

            let blockedDates = [];
            let isLoadingDates = false;

            // Fetch blocked dates for the property
            async function fetchBlockedDates() {
                if (isLoadingDates) return;
                isLoadingDates = true;

                try {
                    const response = await fetch(`/api/properties/${propertyId}/blocked-dates`);
                    const data = await response.json();
                    blockedDates = data.blocked_dates || [];

                    // Disable already selected dates if they're blocked
                    validateDates();
                } catch (error) {
                    console.error('Error fetching blocked dates:', error);
                } finally {
                    isLoadingDates = false;
                }
            }

            // Check if a date is blocked
            function isDateBlocked(dateString) {
                return blockedDates.includes(dateString);
            }

            // Check if date range has any blocked dates
            function hasBlockedDatesInRange(startDate, endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const current = new Date(start);

                while (current < end) {
                    const dateStr = current.toISOString().split('T')[0];
                    if (isDateBlocked(dateStr)) {
                        return true;
                    }
                    current.setDate(current.getDate() + 1);
                }
                return false;
            }

            // Calculate nights and total price
            function calculatePrice() {
                const checkIn = checkInInput.value;
                const checkOut = checkOutInput.value;

                if (!checkIn || !checkOut) {
                    priceDisplay.classList.add('hidden');
                    return;
                }

                const start = new Date(checkIn);
                const end = new Date(checkOut);
                const nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

                if (nights > 0) {
                    const total = nights * dailyRate;
                    nightsCount.textContent = nights;
                    totalAmount.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    priceDisplay.classList.remove('hidden');
                } else {
                    priceDisplay.classList.add('hidden');
                }
            }

            // Validate selected dates
            function validateDates() {
                const checkIn = checkInInput.value;
                const checkOut = checkOutInput.value;

                if (!checkIn || !checkOut) {
                    submitBtn.disabled = true;
                    return;
                }

                // Check if any date in the range is blocked
                if (hasBlockedDatesInRange(checkIn, checkOut)) {
                    submitBtn.disabled = true;
                    alert('Selected dates are not available. Please choose different dates.');
                    return;
                }

                submitBtn.disabled = false;
                calculatePrice();
            }

            // Update min date for check-out when check-in changes
            checkInInput.addEventListener('change', function () {
                const checkInDate = new Date(this.value);
                checkInDate.setDate(checkInDate.getDate() + 1);
                checkOutInput.min = checkInDate.toISOString().split('T')[0];

                if (checkOutInput.value && new Date(checkOutInput.value) <= new Date(this.value)) {
                    checkOutInput.value = '';
                }

                validateDates();
            });

            checkOutInput.addEventListener('change', function () {
                validateDates();
            });

            // Add custom validation for date picker (disable blocked dates)
            function addDateValidation() {
                [checkInInput, checkOutInput].forEach(input => {
                    input.addEventListener('input', function (e) {
                        const selectedDate = e.target.value;
                        if (selectedDate && isDateBlocked(selectedDate)) {
                            e.target.value = '';
                            alert('This date is not available. Please select another date.');
                        }
                    });
                });
            }

            // Initialize
            fetchBlockedDates().then(() => {
                addDateValidation();
                if (checkInInput.value && checkOutInput.value) {
                    validateDates();
                }
            });
        </script>
    @endif
</x-app-layout>