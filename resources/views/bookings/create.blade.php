@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Create Booking</h2>

    <form method="POST" action="{{ route('bookings.store') }}">
        @csrf
        <label class="block mb-2">Property</label>
        <select name="property_id" class="border rounded w-full mb-4 p-2">
            @foreach ($properties as $property)
                <option value="{{ $property->id }}">{{ $property->title }}</option>
            @endforeach
        </select>

        <label class="block mb-2">Start Date</label>
        <input type="date" name="start_date" class="border rounded w-full mb-4 p-2" required>

        <label class="block mb-2">End Date</label>
        <input type="date" name="end_date" class="border rounded w-full mb-4 p-2" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>
@endsection
