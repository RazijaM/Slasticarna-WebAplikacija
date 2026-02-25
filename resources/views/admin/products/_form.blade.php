@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">
            {{ __('Category') }}
        </label>
        <select
            id="category_id"
            name="category_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required
        >
            <option value="">{{ __('Select category') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? null) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">
            {{ __('Name') }}
        </label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required
        >
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700">
            {{ __('Description') }}
        </label>
        <textarea
            id="description"
            name="description"
            rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required
        >{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">
            {{ __('Price') }}
        </label>
        <input
            type="number"
            step="0.01"
            min="0"
            id="price"
            name="price"
            value="{{ old('price', $product->price ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required
        >
        @error('price')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="stock" class="block text-sm font-medium text-gray-700">
            {{ __('Stock') }}
        </label>
        <input
            type="number"
            min="0"
            id="stock"
            name="stock"
            value="{{ old('stock', $product->stock ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            required
        >
        @error('stock')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">
            {{ __('Image') }}
        </label>
        <input
            type="file"
            id="image"
            name="image"
            accept=".jpg,.jpeg,.png,.webp"
            class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none"
        >
        <p class="mt-1 text-xs text-gray-500">
            {{ __('JPG, PNG or WEBP up to 2MB.') }}
        </p>
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @if (!empty($product?->image_path))
            <div class="mt-3">
                <p class="text-xs text-gray-500 mb-1">
                    {{ __('Current image') }}:
                </p>
                <img
                    src="{{ asset('storage/'.$product->image_path) }}"
                    alt="{{ $product->name }}"
                    class="h-20 w-20 rounded object-cover"
                >
            </div>
        @endif
    </div>

    <div class="flex items-center space-x-2">
        <input
            type="checkbox"
            id="is_active"
            name="is_active"
            value="1"
            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
            @checked(old('is_active', $product->is_active ?? true))
        >
        <label for="is_active" class="text-sm font-medium text-gray-700">
            {{ __('Active') }}
        </label>
        @error('is_active')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 flex items-center justify-end space-x-3">
    <a href="{{ route('admin.products.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
        {{ __('Cancel') }}
    </a>
    <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        {{ $submitLabel ?? __('Save') }}
    </button>
</div>

