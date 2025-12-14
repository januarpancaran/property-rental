<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&family=plus-jakarta-sans:400,500,600,700"
        rel="stylesheet" />
    <!-- Styles -->
    @vite(['resources/css/app.css'])
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
        }

        .property-card {
            transition: all 0.3s ease;
        }

        .property-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav
        class="bg-white dark:bg-gray-800/95 backdrop-blur-md shadow-md fixed w-full top-0 z-50 border-b border-gray-200/20 dark:border-gray-700/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: App Name -->
                <div class="flex items-center">
                    <a href="/"
                        class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <!-- Right: Auth Actions -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg text-sm font-semibold transition shadow-lg hover:shadow-xl">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-6 py-2 text-gray-700 dark:text-gray-200 rounded-lg text-sm font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg text-sm font-semibold transition shadow-lg hover:shadow-xl">
                                Sign up
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-gradient relative pt-20 pb-32 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl">
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-6 inline-block">
                <span
                    class="inline-flex items-center rounded-full bg-white/20 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm border border-white/30">
                    ✨ Welcome to smarter rental living
                </span>
            </div>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                Find Your <span
                    class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-cyan-200">Perfect
                    Rental</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-50 max-w-3xl mx-auto mb-10 leading-relaxed">
                Discover verified properties, book instantly, and manage your stay—all in one seamless platform.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('properties.index') }}"
                    class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-lg shadow-xl hover:shadow-2xl hover:scale-105 transition inline-block">
                    Browse Properties
                </a>
                <a href="#features"
                    class="px-8 py-4 bg-white/20 backdrop-blur-md border border-white/30 hover:bg-white/30 text-white font-bold rounded-lg transition inline-block">
                    Learn More
                </a>
            </div>
        </div>
    </header>

    <!-- Main Features -->
    <section id="features" class="py-24 bg-gray-50 dark:bg-gray-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Why Choose Us?</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Everything you need for a seamless
                    rental experience</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="feature-card bg-white dark:bg-gray-800 rounded-2xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Verified Listings</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Every property is carefully verified for authenticity and quality. We ensure only legitimate
                        listings are available.
                    </p>
                </div>
                <div
                    class="feature-card bg-white dark:bg-gray-800 rounded-2xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Secure Payments</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Pay safely with multiple trusted payment methods. Your financial information is always
                        protected.
                    </p>
                </div>
                <div
                    class="feature-card bg-white dark:bg-gray-800 rounded-2xl p-8 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">24/7 Support</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Our dedicated support team is always here to help. Get answers quickly whenever you need
                        assistance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Properties -->
    <section class="py-24 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-16 gap-4">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white">Featured Properties</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Handpicked homes just for you</p>
                </div>
                <a href="{{ route('properties.index') }}"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl inline-block">
                    Show More →
                </a>
            </div>

            @if ($properties->count() > 0)
                <div class="overflow-x-auto pb-4 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 scrollbar-hide">
                    <div class="flex gap-6 min-w-min">
                        @foreach ($properties as $property)
                            <div
                                class="property-card flex-shrink-0 w-80 bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
                                <div class="h-48 bg-gray-200 dark:bg-gray-700 relative overflow-hidden group">
                                    @if ($property->featuredPhoto)
                                        <img src="{{ $property->featuredPhoto->url }}" alt="{{ $property->title }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-gray-400 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h3
                                        class="font-bold text-gray-900 dark:text-white text-base mb-2 line-clamp-2 h-14">
                                        {{ $property->title }}
                                    </h3>
                                    <div class="flex items-baseline gap-2 mb-4">
                                        <span
                                            class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                            Rp {{ number_format($property->rent_amount, 0, ',', '.') }}
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">/month</span>
                                    </div>
                                    <div
                                        class="flex flex-wrap gap-3 text-sm text-gray-600 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-4">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5" />
                                            </svg>
                                            <span>{{ $property->bedrooms }} beds</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5" />
                                            </svg>
                                            <span class="truncate">{{ $property->city }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12a9 9 0 109 9m0 0l3-3m-3 3l-3-3" />
                    </svg>
                    <p class="text-lg text-gray-500 dark:text-gray-400">No properties available yet.</p>
                    <p class="text-gray-400 dark:text-gray-500 mt-1">Check back soon for exciting new listings!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to find your next home?</h2>
            <p class="text-lg text-blue-50 mb-8">Join thousands of satisfied renters exploring properties on our
                platform.</p>
            <a href="{{ route('properties.index') }}"
                class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-lg hover:bg-blue-50 transition shadow-xl hover:shadow-2xl inline-block">
                Explore All Properties
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-gray-950 text-gray-400 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">{{ config('app.name') }}</h3>
                    <p class="text-gray-500">Making rental living seamless and transparent for everyone.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Properties</a></li>
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">Safety Tips</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 mb-4 md:mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights
                    reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-500 hover:text-white transition">Twitter</a>
                    <a href="#" class="text-gray-500 hover:text-white transition">Facebook</a>
                    <a href="#" class="text-gray-500 hover:text-white transition">Instagram</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
