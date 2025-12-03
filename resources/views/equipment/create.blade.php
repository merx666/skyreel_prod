@extends('layouts.app')

@section('title', __('Dodaj sprzęt'))

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('equipment.index') }}" 
                   class="text-gray-400 hover:text-white mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-white">{{ __('Dodaj sprzęt') }}</h1>
            </div>
            <p class="text-gray-400">{{ __('Dodaj nowy sprzęt do swojego profilu') }}</p>
        </div>

        <!-- Form -->
        <div class="liquid-glass p-8 rounded-lg">
            <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Typ sprzętu') }} <span class="text-red-400">*</span>
                    </label>
                    <select name="type" id="type" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">{{ __('Wybierz typ') }}</option>
                        <option value="drone" {{ old('type') == 'drone' ? 'selected' : '' }}>{{ __('Dron') }}</option>
                        <option value="camera" {{ old('type') == 'camera' ? 'selected' : '' }}>{{ __('Kamera') }}</option>
                        <option value="lens" {{ old('type') == 'lens' ? 'selected' : '' }}>{{ __('Obiektyw') }}</option>
                        <option value="accessory" {{ old('type') == 'accessory' ? 'selected' : '' }}>{{ __('Akcesoria') }}</option>
                    </select>
                    @error('type')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Marka') }} <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="brand" id="brand" value="{{ old('brand') }}" required
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="{{ __('np. DJI, Canon, Sony') }}">
                    @error('brand')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Model -->
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Model') }} <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="model" id="model" value="{{ old('model') }}" required
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="{{ __('np. Mavic 3, EOS R5, A7 IV') }}">
                    @error('model')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Opis') }}
                    </label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="{{ __('Dodatkowe informacje o sprzęcie...') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-300 mb-2">
                        {{ __('Zdjęcie sprzętu') }}
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gray-800 hover:bg-gray-750">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-400">
                                    <span class="font-semibold">{{ __('Kliknij aby wybrać') }}</span> {{ __('lub przeciągnij plik') }}
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF (MAX. 2MB)</p>
                            </div>
                            <input id="image" name="image" type="file" class="hidden" accept="image/*">
                        </label>
                    </div>
                    @error('image')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex space-x-4 pt-6">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        {{ __('Dodaj sprzęt') }}
                    </button>
                    <a href="{{ route('equipment.index') }}" 
                       class="flex-1 text-center px-6 py-3 border border-gray-600 text-gray-300 hover:text-white hover:border-gray-500 font-medium rounded-lg transition-colors">
                        {{ __('Anuluj') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const label = e.target.closest('label');
        const content = label.querySelector('div');
        content.innerHTML = `
            <i class="fas fa-check text-2xl text-green-400 mb-2"></i>
            <p class="text-sm text-green-400 font-semibold">${file.name}</p>
            <p class="text-xs text-gray-500">{{ __('Kliknij aby zmienić') }}</p>
        `;
    }
});
</script>
@endsection