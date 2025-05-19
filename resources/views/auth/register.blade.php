<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Register - {{ config('app.name', 'Roomza') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-green-50 to-white min-h-screen" x-data="registration">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}">
                                <img class="h-4 w-auto" src="{{ asset('images/logo-green.png') }}" alt="{{ config('app.name', 'Roomza') }}">
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-green-500">Already have an account?</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Registration Form -->
        <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-xl w-full">
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="h-2 bg-gray-200 rounded-full">
                        <div class="h-full bg-green-500 rounded-full transition-all duration-500" :style="`width: ${(currentStep / totalSteps) * 100}%`"></div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500 text-right" x-text="`Step ${currentStep} of ${totalSteps}`"></div>
                </div>

                <div class="bg-white shadow-xl rounded-xl p-8">
                    <form method="POST" action="{{ route('register') }}" @submit.prevent="submitForm">
                        @csrf
                        
                        <!-- Hidden inputs for all form data -->
                        <input type="hidden" name="name" :value="formData.name">
                        <input type="hidden" name="email" :value="formData.email">
                        <input type="hidden" name="phone" :value="formData.phone">
                        <input type="hidden" name="business_type" :value="formData.business_type">
                        <input type="hidden" name="password" :value="formData.password">
                        <input type="hidden" name="password_confirmation" :value="formData.password_confirmation">
                        
                        <!-- Welcome Screen -->
                        <div x-show="currentStep === 1" x-transition>
                            <div class="text-center">
                                <!-- <img src="{{ asset('images/logo-green.png') }}" class="w-48 h-48 mx-auto mb-6" alt="Welcome"> -->
                                <h2 class="text-3xl font-bold text-gray-900 mb-4">Welcome to Roomza</h2>
                                <p class="text-gray-600 mb-8">Let's get you set up with your account. It'll only take a few minutes.</p>
                                <button type="button" @click="nextStep" class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-lg font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300">
                                    Get Started
                                    <svg class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Name Field -->
                        <div x-show.transition="currentStep === 2">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">What's your name?</h3>
                            <p class="text-gray-600 mb-6">Let's start with your name so we can personalize your experience.</p>
                            <div class="space-y-4">
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    x-model="formData.name"
                                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg"
                                    placeholder="Enter your full name"
                                    @keyup.enter="nextStep"
                                    :disabled="currentStep !== 2"
                                >
                                <p class="text-red-500 text-sm" x-show="errors.name" x-text="errors.name"></p>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div x-show.transition="currentStep === 3">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">What's your email?</h3>
                            <p class="text-gray-600 mb-6">We'll use this to keep you updated about your account.</p>
                            <div class="space-y-4">
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    x-model="formData.email"
                                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg"
                                    placeholder="Enter your email address"
                                    @keyup.enter="nextStep"
                                    :disabled="currentStep !== 3"
                                >
                                <p class="text-red-500 text-sm" x-show="errors.email" x-text="errors.email"></p>
                            </div>
                        </div>

                        <!-- Phone Field -->
                        <div x-show.transition="currentStep === 4">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Your phone number</h3>
                            <p class="text-gray-600 mb-6">We'll use this to send you important updates about your listings.</p>
                            <div class="space-y-4">
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    x-model="formData.phone"
                                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg"
                                    placeholder="Enter your phone number"
                                    @keyup.enter="nextStep"
                                    :disabled="currentStep !== 4"
                                >
                                <p class="text-red-500 text-sm" x-show="errors.phone" x-text="errors.phone"></p>
                            </div>
                        </div>


                        <!-- Business Type -->
                        <div x-show="currentStep === 5" x-transition>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Choose your account type</h3>
                            <p class="text-gray-600 mb-6">Select the option that best describes your needs.</p>
                            <div class="space-y-4">
                                <template x-for="type in businessTypes" :key="type.value">
                                    <div 
                                        class="p-4 border rounded-lg cursor-pointer transition-all duration-300"
                                        :class="formData.business_type === type.value ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-200'"
                                        @click="formData.business_type = type.value; nextStep()"
                                    >
                                        <h4 class="font-medium text-gray-900" x-text="type.label"></h4>
                                        <p class="text-sm text-gray-500" x-text="type.description"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div x-show="currentStep === 6" x-transition>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Create a password</h3>
                            <p class="text-gray-600 mb-6">Make sure it's secure and easy to remember.</p>
                            <div class="space-y-4">
                                <div>
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password" 
                                        x-model="formData.password"
                                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg"
                                        placeholder="Enter your password"
                                    >
                                    <div class="mt-2">
                                        <div class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-green-500 transition-all duration-300" :style="{ width: passwordStrength + '%' }"></div>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500" x-text="passwordFeedback"></p>
                                    </div>
                                </div>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    x-model="formData.password_confirmation"
                                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg"
                                    placeholder="Confirm your password"
                                >
                                <p class="text-red-500 text-sm" x-show="errors.password" x-text="errors.password"></p>
                                
                                <!-- Create Account Button -->
                                <button 
                                    type="button"
                                    @click="submitForm"
                                    class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-lg font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300"
                                >
                                    Create Account
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="mt-8 flex justify-between items-center" x-show="currentStep > 1">
                            <button 
                                type="button" 
                                @click="prevStep"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            >
                                Back
                            </button>
                            <button 
                                type="button" 
                                x-show="currentStep < totalSteps"
                                @click="nextStep"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            >
                                Next
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('registration', () => ({
                    currentStep: 1,
                    totalSteps: 6,
                    formData: {
                        name: '',
                        email: '',
                        phone: '',
                        business_type: '',
                        password: '',
                        password_confirmation: ''
                    },
                    errors: {},
                    businessTypes: [
                        {
                            value: 'personal',
                            label: 'Personal Account',
                            description: 'I want to browse and book accommodations'
                        },
                        {
                            value: 'business',
                            label: 'Business Account',
                            description: 'I own/manage properties and want to list them'
                        }
                    ],
                    submitForm() {
                        // Reset errors
                        this.errors = {};
                        
                        // Validate all required fields
                        if (!this.formData.name) this.errors.name = 'Name is required';
                        if (!this.formData.email) this.errors.email = 'Email is required';
                        if (!this.formData.phone) this.errors.phone = 'Phone is required';
                        if (!this.formData.business_type) this.errors.business_type = 'Business type is required';
                        if (!this.formData.password) this.errors.password = 'Password is required';
                        if (this.formData.password !== this.formData.password_confirmation) {
                            this.errors.password = 'Passwords do not match';
                        }
                        
                        // If there are no errors, submit the form
                        if (Object.keys(this.errors).length === 0) {
                            // Submit form directly
                            const form = document.querySelector('form');
                            
                            // Update hidden inputs with current values
                            form.querySelector('input[name="name"]').value = this.formData.name;
                            form.querySelector('input[name="email"]').value = this.formData.email;
                            form.querySelector('input[name="phone"]').value = this.formData.phone;
                            form.querySelector('input[name="business_type"]').value = this.formData.business_type;
                            form.querySelector('input[name="password"]').value = this.formData.password;
                            form.querySelector('input[name="password_confirmation"]').value = this.formData.password_confirmation;
                            
                            // Submit the form
                            form.submit();
                        } else {
                            // If there are errors, navigate to the first step with an error
                            for (let i = 2; i <= this.totalSteps; i++) {
                                if (
                                    (i === 2 && this.errors.name) || 
                                    (i === 3 && this.errors.email) || 
                                    (i === 4 && this.errors.phone) || 
                                    (i === 5 && this.errors.business_type) || 
                                    (i === 6 && this.errors.password)
                                ) {
                                    this.currentStep = i;
                                    break;
                                }
                            }
                        }
                    },
                    get passwordStrength() {
                        const password = this.formData.password;
                        if (!password) return 0;
                        let strength = 0;
                        if (password.length >= 8) strength += 25;
                        if (password.match(/[A-Z]/)) strength += 25;
                        if (password.match(/[0-9]/)) strength += 25;
                        if (password.match(/[^A-Za-z0-9]/)) strength += 25;
                        return strength;
                    },
                    get passwordFeedback() {
                        const strength = this.passwordStrength;
                        if (strength === 0) return 'Enter a password';
                        if (strength <= 25) return 'Weak password';
                        if (strength <= 50) return 'Fair password';
                        if (strength <= 75) return 'Good password';
                        return 'Strong password';
                    },
                    nextStep() {
                        if (this.validateStep()) {
                            if (this.currentStep < this.totalSteps) {
                                this.currentStep++;
                            }
                        }
                    },
                    prevStep() {
                        if (this.currentStep > 1) {
                            this.currentStep--;
                        }
                    },
                    validateStep() {
                        this.errors = {};
                        
                        switch(this.currentStep) {
                            case 2:
                                if (!this.formData.name) {
                                    this.errors.name = 'Name is required';
                                    return false;
                                }
                                break;
                            case 3:
                                if (!this.formData.email) {
                                    this.errors.email = 'Email is required';
                                    return false;
                                }
                                if (!this.formData.email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                                    this.errors.email = 'Please enter a valid email';
                                    return false;
                                }
                                break;
                            case 4:
                                if (!this.formData.phone) {
                                    this.errors.phone = 'Phone number is required';
                                    return false;
                                }
                                break;
                            case 6:
                                if (!this.formData.password) {
                                    this.errors.password = 'Password is required';
                                    return false;
                                }
                                if (this.formData.password.length < 8) {
                                    this.errors.password = 'Password must be at least 8 characters';
                                    return false;
                                }
                                if (this.formData.password !== this.formData.password_confirmation) {
                                    this.errors.password = 'Passwords do not match';
                                    return false;
                                }
                                break;
                        }
                        return true;
                    }
                }))
            })
        </script>
    </body>
</html>




