<div class="space-y-6">
    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-300">Nazwa Produktu</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required
               class="mt-1 block w-full rounded-md bg-white/5 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('name')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Category -->
    <div>
        <label for="category" class="block text-sm font-medium text-gray-300">Kategoria</label>
        <select name="category" id="category" required
                class="mt-1 block w-full rounded-md bg-white/5 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="" disabled {{ !isset($product) ? 'selected' : '' }}>Wybierz kategorię</option>
            @foreach(['Drony', 'Akcesoria', 'FPV', 'Części', 'Inne'] as $cat)
                <option value="{{ $cat }}" {{ (old('category', $product->category ?? '') == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        @error('category')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Price -->
    <div>
        <label for="price" class="block text-sm font-medium text-gray-300">Cena (PLN)</label>
        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" required
               class="mt-1 block w-full rounded-md bg-white/5 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('price')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-300">Opis</label>
        <textarea name="description" id="description" rows="4" required
                  class="mt-1 block w-full rounded-md bg-white/5 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Image -->
    <div>
        <label class="block text-sm font-medium text-gray-300">Zdjęcie</label>
        <div class="mt-1 flex items-center space-x-4">
            @if(isset($product) && $product->image_url)
                <img src="{{ $product->image_url }}" alt="Current Image" class="h-20 w-20 object-cover rounded-md">
            @endif
            <input type="file" name="image" id="image" accept="image/*"
                   class="block w-full text-sm text-gray-300
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-indigo-600 file:text-white
                          file:hover:bg-indigo-700">
        </div>
        <p class="mt-1 text-xs text-gray-400">Pozostaw puste, aby zachować obecne zdjęcie (przy edycji).</p>
        @error('image')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Affiliate Link (Optional) -->
    <div>
        <label for="affiliate_link" class="block text-sm font-medium text-gray-300">Link Afiliacyjny (opcjonalnie)</label>
        <input type="url" name="affiliate_link" id="affiliate_link" value="{{ old('affiliate_link', $product->affiliate_link ?? '') }}"
               class="mt-1 block w-full rounded-md bg-white/5 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               placeholder="https://...">
        @error('affiliate_link')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.products.index') }}" class="btn-secondary mr-3 px-4 py-2">Anuluj</a>
        <button type="submit" class="btn-primary px-4 py-2">
            {{ isset($product) ? 'Zapisz Zmiany' : 'Dodaj Produkt' }}
        </button>
    </div>
</div>
