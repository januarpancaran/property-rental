@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'border-gray-700 dark:border-gray-700 bg-gray-700 dark:bg-gray-700 text-white dark:text-gray-200 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 dark:focus:ring-orange-500 rounded-md shadow-sm']) !!}>