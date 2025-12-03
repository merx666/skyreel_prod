@extends('layouts.app')

@section('title', __('Settings'))

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="liquid-glass rounded-2xl p-8">
            <h1 class="text-3xl font-bold text-white mb-8">{{ __('Settings') }}</h1>
            
            <div class="space-y-8">
                <!-- Profile Settings -->
                <div class="border-b border-gray-700 pb-8">
                    <h2 class="text-xl font-semibold text-white mb-4">{{ __('Profile Settings') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Name') }}</label>
                            <input type="text" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Email') }}</label>
                            <input type="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="border-b border-gray-700 pb-8">
                    <h2 class="text-xl font-semibold text-white mb-4">{{ __('Notifications') }}</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-medium">{{ __('Email Notifications') }}</h3>
                                <p class="text-gray-400 text-sm">{{ __('Receive notifications about new jobs and messages') }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-medium">{{ __('Push Notifications') }}</h3>
                                <p class="text-gray-400 text-sm">{{ __('Receive push notifications in your browser') }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="border-b border-gray-700 pb-8">
                    <h2 class="text-xl font-semibold text-white mb-4">{{ __('Privacy') }}</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-white font-medium">{{ __('Profile Visibility') }}</h3>
                                <p class="text-gray-400 text-sm">{{ __('Make your profile visible to other users') }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div>
                    <h2 class="text-xl font-semibold text-white mb-4">{{ __('Account') }}</h2>
                    <div class="space-y-4">
                        <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            {{ __('Save Changes') }}
                        </button>
                        <button class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors ml-4">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection