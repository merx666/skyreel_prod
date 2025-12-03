@extends('layouts.app')

@section('title', __('Mój sprzęt'))

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white">{{ __('Mój sprzęt') }}</h1>
                <p class="text-gray-400 mt-2">{{ __('Zarządzaj swoim sprzętem fotograficznym i filmowym') }}</p>
            </div>
            <a href="{{ route('equipment.create') }}" 
               class="liquid-glass px-6 py-3 text-blue-400 hover:text-blue-300 font-medium rounded-lg transition-all duration-200 hover:scale-105">
                <i class="fas fa-plus mr-2"></i>{{ __('Dodaj sprzęt') }}
            </a>
        </div>

        @if(session('success'))
            <div class="liquid-glass border border-green-500/20 bg-green-500/10 text-green-400 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($equipment->count() > 0)
            <!-- Equipment Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($equipment as $item)
                    <div class="liquid-glass p-6 rounded-lg hover:scale-105 transition-all duration-200">
                        @if($item->image_url)
                            <div class="aspect-video bg-gray-800 rounded-lg mb-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->image_url) }}" 
                                     alt="{{ $item->brand }} {{ $item->model }}"
                                     class="w-full h-full object-cover"
                                     loading="lazy">
                            </div>
                        @else
                            <div class="aspect-video bg-gray-800 rounded-lg mb-4 flex items-center justify-center">
                                <i class="fas fa-camera text-4xl text-gray-600"></i>
                            </div>
                        @endif

                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center space-x-2 px-3 py-1 text-xs font-medium bg-blue-500/20 text-blue-400 rounded-full">
                                    @if($item->type === 'drone')
                                        <i class="fas fa-helicopter"></i>
                                    @elseif($item->type === 'camera')
                                        <i class="fas fa-camera"></i>
                                    @elseif($item->type === 'lens')
                                        <i class="fas fa-eye"></i>
                                    @else
                                        <i class="fas fa-cog"></i>
                                    @endif
                                    <span>{{ $item->type_display }}</span>
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-1">{{ $item->brand }} {{ $item->model }}</h3>
                            @if($item->description)
                                <p class="text-gray-400 text-sm line-clamp-2">{{ $item->description }}</p>
                            @endif
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('equipment.show', $item) }}" 
                               class="flex-1 text-center px-3 py-2 text-sm text-blue-400 hover:text-blue-300 border border-blue-500/30 rounded-lg transition-colors">
                                {{ __('Zobacz') }}
                            </a>
                            <a href="{{ route('equipment.edit', $item) }}" 
                               class="flex-1 text-center px-3 py-2 text-sm text-yellow-400 hover:text-yellow-300 border border-yellow-500/30 rounded-lg transition-colors">
                                {{ __('Edytuj') }}
                            </a>
                            <form action="{{ route('equipment.destroy', $item) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('{{ __('Czy na pewno chcesz usunąć ten sprzęt?') }}')"
                                        class="w-full px-3 py-2 text-sm text-red-400 hover:text-red-300 border border-red-500/30 rounded-lg transition-colors">
                                    {{ __('Usuń') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $equipment->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="liquid-glass p-8 rounded-lg max-w-md mx-auto">
                    <i class="fas fa-camera text-6xl text-gray-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-white mb-2">{{ __('Brak sprzętu') }}</h3>
                    <p class="text-gray-400 mb-6">{{ __('Dodaj swój pierwszy sprzęt, aby pokazać klientom czego używasz.') }}</p>
                    <a href="{{ route('equipment.create') }}" 
                       class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        {{ __('Dodaj sprzęt') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection