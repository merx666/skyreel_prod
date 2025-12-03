@extends('layouts.app')

@section('title', $equipment->brand . ' ' . $equipment->model)

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('equipment.index') }}" 
                   class="text-gray-400 hover:text-white mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-white">{{ $equipment->brand }} {{ $equipment->model }}</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center space-x-2 px-3 py-1 text-sm font-medium bg-blue-500/20 text-blue-400 rounded-full">
                    @if($equipment->type === 'drone')
                        <i class="fas fa-helicopter"></i>
                    @elseif($equipment->type === 'camera')
                        <i class="fas fa-camera"></i>
                    @elseif($equipment->type === 'lens')
                        <i class="fas fa-eye"></i>
                    @else
                        <i class="fas fa-cog"></i>
                    @endif
                    <span>{{ $equipment->type_display }}</span>
                </span>
                <span class="text-gray-400">{{ __('Dodano') }} {{ $equipment->created_at->diffForHumans() }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image -->
            <div class="liquid-glass p-6 rounded-lg">
                @if($equipment->image_url)
                    <div class="aspect-square bg-gray-800 rounded-lg overflow-hidden mb-4">
                        <img src="{{ Storage::url($equipment->image_url) }}" 
                             alt="{{ $equipment->brand }} {{ $equipment->model }}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>
                @else
                    <div class="aspect-square bg-gray-800 rounded-lg flex items-center justify-center mb-4">
                        @if($equipment->type === 'drone')
                            <i class="fas fa-helicopter text-8xl text-gray-600"></i>
                        @elseif($equipment->type === 'camera')
                            <i class="fas fa-camera text-8xl text-gray-600"></i>
                        @elseif($equipment->type === 'lens')
                            <i class="fas fa-eye text-8xl text-gray-600"></i>
                        @else
                            <i class="fas fa-cog text-8xl text-gray-600"></i>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Details -->
            <div class="liquid-glass p-6 rounded-lg">
                <h2 class="text-2xl font-bold text-white mb-6">{{ __('Szczegóły sprzętu') }}</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">{{ __('Typ') }}</label>
                        <p class="text-white">{{ $equipment->type_display }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">{{ __('Marka') }}</label>
                        <p class="text-white">{{ $equipment->brand }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">{{ __('Model') }}</label>
                        <p class="text-white">{{ $equipment->model }}</p>
                    </div>

                    @if($equipment->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">{{ __('Opis') }}</label>
                        <p class="text-white">{{ $equipment->description }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">{{ __('Data dodania') }}</label>
                        <p class="text-white">{{ $equipment->created_at->format('d.m.Y H:i') }}</p>
                    </div>

                    @if($equipment->updated_at->ne($equipment->created_at))
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">{{ __('Ostatnia aktualizacja') }}</label>
                        <p class="text-white">{{ $equipment->updated_at->format('d.m.Y H:i') }}</p>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                @can('update', $equipment)
                <div class="flex space-x-4 mt-8 pt-6 border-t border-gray-700">
                    <a href="{{ route('equipment.edit', $equipment) }}" 
                       class="flex-1 text-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-edit mr-2"></i>{{ __('Edytuj') }}
                    </a>
                    <form action="{{ route('equipment.destroy', $equipment) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Czy na pewno chcesz usunąć ten sprzęt?')"
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i>{{ __('Usuń') }}
                        </button>
                    </form>
                </div>
                @endcan
            </div>
        </div>

        <!-- Owner Info (if viewing someone else's equipment) -->
        @if($equipment->user_id !== auth()->id())
        <div class="liquid-glass p-6 rounded-lg mt-8">
            <h3 class="text-xl font-bold text-white mb-4">{{ __('Właściciel') }}</h3>
            <div class="flex items-center space-x-4">
                @if($equipment->user->profile && $equipment->user->profile->profile_picture_url)
                    <img src="{{ Storage::url($equipment->user->profile->profile_picture_url) }}" 
                         alt="{{ $equipment->user->name }}"
                         class="w-12 h-12 rounded-full object-cover">
                @else
                    <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                @endif
                <div>
                    <h4 class="text-white font-medium">{{ $equipment->user->name }}</h4>
                    @if($equipment->user->profile && $equipment->user->profile->location)
                        <p class="text-gray-400 text-sm">{{ $equipment->user->profile->location }}</p>
                    @endif
                </div>
                <div class="ml-auto">
                    <a href="{{ route('profile.show', $equipment->user) }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        {{ __('Zobacz profil') }}
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection