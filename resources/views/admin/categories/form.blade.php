<x-admin-layout :title="$category->exists ? 'Edit Category' : 'Add Category'">
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-lg p-6">

        <form method="POST"
              action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if($category->exists)
                @method('PUT')
            @endif

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500"
                       required>
                @error('name') <p class="text-sm text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}"
                   class="text-gray-700 hover:text-gray-900 text-sm font-medium">
                    Cancel
                </a>

                <button class="bg-violet-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-violet-700">
                    {{ $category->exists ? 'Save Changes' : 'Create Category' }}
                </button>
            </div>

        </form>

    </div>
</x-admin-layout>
