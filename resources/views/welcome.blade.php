<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Roomza') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900 pb-16 md:pb-0">
        <!-- Header -->
        <x-header />
        
        <!-- Main Navigation -->
        <x-main-navigation />

        <!-- Hero Section with Search -->
        <x-hero-section />

        <!-- Property Types -->
        <x-property-types-section />
        
        <!-- Featured Properties -->
        <x-featured-properties-section :properties="$featuredProperties ?? collect()" />
        
        <!-- Popular Locations -->
        <x-popular-locations-section :cities="$popularCities ?? collect()" />
        
        <!-- CTA Section -->
        <x-cta-section />
        
        <!-- Footer -->
        <x-footer />
        
        <!-- Bottom Navigation -->
        <x-bottom-navigation />
    </body>
</html>




