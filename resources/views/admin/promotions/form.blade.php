@php
    $isEdit = $promotion->exists;
@endphp

<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $isEdit ? 'Edit Promotion' : 'New Promotion' }}
            </h1>
            <p class="text-sm text-gray-500">
                {{ $isEdit ? 'Update promotion details and validity.' : 'Create a new discount promotion.' }}
            </p>
        </div>
        <a href="{{ route('admin.promotions.index') }}"
           class="text-sm text-gray-600 hover:text-gray-900">
            ← Back to Promotions
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="font-semibold mb-1">Please fix the following:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
        <form method="POST"
              action="{{ $isEdit
                    ? route('admin.promotions.update', $promotion)
                    : route('admin.promotions.store') }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- LEFT SIDE --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $promotion->name) }}"
                               class="w-full border rounded-lg px-3 py-2 text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                        <input type="text" name="code"
                               value="{{ old('code', $promotion->code) }}"
                               class="w-full border rounded-lg px-3 py-2 text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500 uppercase"
                               placeholder="e.g. PAWS10"
                               required>
                        <p class="text-xs text-gray-400 mt-1">Customers will enter this code during checkout.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full border rounded-lg px-3 py-2 text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500"
                                  placeholder="Short description of this promo (visible to staff).">{{ old('description', $promotion->description) }}</textarea>
                    </div>
                </div>

                {{-- RIGHT SIDE --}}
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                            <select name="discount_type"
                                    class="w-full border rounded-lg px-3 py-2 text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500">
                                <option value="percent" @selected(old('discount_type', $promotion->discount_type) === 'percent')>
                                    Percentage (%)
                                </option>
                                <option value="fixed" @selected(old('discount_type', $promotion->discount_type) === 'fixed')>
                                    Fixed Amount (₱)
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                            <input type="number" step="0.01" min="0" name="discount_value"
                                   value="{{ old('discount_value', $promotion->discount_value) }}"
                                   class="w-full border rounded-lg px-3 py-2 text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Amount (optional)</label>
                        <input type="number" step="0.01" min="0" name="min_order_amount"
                               value="{{ old('min_order_amount', $promotion->min_order_amount) }}"
                               class="w-full border rounded-lg px-3 py-2 text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500"
                               placeholder="e.g. 1000.00">
                        <p class="text-xs text-gray-400 mt-1">Leave blank if no minimum is required.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Starts At</label>
                            <input type="datetime-local" name="starts_at"
                                   value="{{ old('starts_at', optional($promotion->starts_at)->format('Y-m-d\TH:i')) }}"
                                   class="w-full border rounded-lg px-3 py-2 text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ends At</label>
                            <input type="datetime-local" name="ends_at"
                                   value="{{ old('ends_at', optional($promotion->ends_at)->format('Y-m-d\TH:i')) }}"
                                   class="w-full border rounded-lg px-3 py-2 text-sm border-gray-300 focus:ring-violet-500 focus:border-violet-500">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-2">
                        <input type="checkbox" name="is_active" id="is_active"
                               value="1"
                               @checked(old('is_active', $promotion->is_active ?? true)) 
                               class="rounded border-gray-300 text-violet-600 focus:ring-violet-500">
                        <label for="is_active" class="text-sm text-gray-700">
                            Promotion is active
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.promotions.index') }}"
                   class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-violet-600 text-white text-sm font-semibold shadow hover:bg-violet-700">
                    {{ $isEdit ? 'Save Changes' : 'Create Promotion' }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
