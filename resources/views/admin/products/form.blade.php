<x-admin-layout>
    <div class="flex flex-col gap-6">

    <div class="sticky top-0 z-10 bg-white border-b border-gray-200 py-3 px-4 sm:px-6 -mx-4 sm:-mx-6 lg:-mx-8 flex items-center justify-between">
        <h1 class="text-xl font-bold text-gray-900 ml-4 sm:ml-0">
            {{ $product->exists ? 'Edit Product' : 'Add New Product' }}
        </h1>
        <div class="flex items-center gap-3 mr-4 sm:mr-0">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-150 font-medium">Cancel</a>
        
            <button type="submit" form="product-form"
                    class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700 transition duration-150 font-semibold shadow-md">
                {{ $product->exists ? 'Save Changes' : 'Save Product' }}
            </button>
        </div>
</div>

    @php
        $existingImageUrl = $product->exists && $product->image_url ? Storage::url($product->image_url) : null;
    @endphp

    
    
    <form
        id="product-form"
        x-data="{
            preview: @js($existingImageUrl),
            onFile(e) {
                const [f] = e.target.files || [];
                if (!f) return;
                this.preview = URL.createObjectURL(f);
            }
        }"
        method="POST"
        enctype="multipart/form-data"
        action="{{ $product->exists ? route('admin.products.update',$product) : route('admin.products.store') }}"
        class="grid grid-cols-1 lg:grid-cols-3 gap-6 pt-2"
    >
        @csrf
        @if($product->exists) @method('PUT') @endif

        <div class="lg:col-span-2 flex flex-col gap-6">

            <div class="bg-white rounded-xl shadow-sm p-6 space-y-5 border-t-4 border-violet-600">
                <h3 class="text-lg font-bold text-gray-900 border-b pb-3 -mx-6 px-6">Basic Information</h3>
                
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">Product Name <span class="text-rose-600">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name',$product->name) }}" required placeholder="Enter product name"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                    @error('name')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700">Category <span class="text-rose-600">*</span></label>
                    <select id="category_id" name="category_id" required 
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id',$product->category_id)==$c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700">Full Description <span class="text-rose-600">*</span></label>
                    <textarea name="description" id="description" rows="5" required placeholder="Manufactured by:"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500">{{ old('description',$product->description) }}</textarea>
                    @error('description')<div class="text-rose-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 space-y-5 border-t-4 border-violet-600">
                <h3 class="text-lg font-bold text-gray-900 border-b pb-3 -mx-6 px-6">Pricing & Inventory</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700">Price <span class="text-rose-600">*</span></label>
                        <div class="mt-1 relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₱</span>
                            </div>
                            <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price',$product->price) }}" required placeholder="0.00"
                                class="block w-full pl-7 pr-3 rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                        </div>
                    </div>

                    <div>
                        <label for="cost_price" class="block text-sm font-semibold text-gray-700">Cost Price <span class="text-rose-600">*</span></label>
                        <div class="mt-1 relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₱</span>
                            </div>
                            <input type="number" step="0.01" min="0" name="cost_price" id="cost_price" value="{{ old('cost_price',$product->cost_price) }}" required placeholder="0.00"
                                class="block w-full pl-7 pr-3 rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                        </div>
                    </div>

                    
                    
                    <div>
                        <label for="unit" class="block text-sm font-semibold text-gray-700">Unit <span class="text-rose-600">*</span></label>
                        <input type="text" name="unit" id="unit" value="{{ old('unit', $product->exists ? $product->unit : '1kg') }}" required placeholder="e.g., each, kg, liter"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                    </div>
                    
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700">Stock Quantity <span class="text-rose-600">*</span></label>
                        <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', $product->exists ? $product->stock : 1) }}"  required placeholder="1"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 flex flex-col gap-6">

            <div class="bg-white rounded-xl shadow-sm p-6 space-y-4 border-t-4 border-violet-600">
                <h3 class="text-lg font-bold text-gray-900 border-b pb-3 -mx-6 px-6">Product Status</h3>
                
                <div class="flex items-center justify-between">
                    <label for="is_active_toggle" class="text-sm font-medium text-gray-700">Product is Active</label>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" id="is_active_toggle" class="sr-only peer" @checked(old('is_active', $product->is_active ?? true))>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet-300 dark:peer-focus:ring-violet-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                    </label>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 space-y-4 border-t-4 border-violet-600">
                <h3 class="text-lg font-bold text-gray-900 border-b pb-3 -mx-6 px-6">Product Image <span class="text-rose-600 text-base">*</span></h3>
                
                <label for="image_upload" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:border-violet-400 transition duration-150">
                    <svg class="w-8 h-8 text-violet-600 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14.899L7.5 11.399L10.5 14.399L16 8.899M16 8.899H13.5M16 8.899V11.399M21 15V9C21 8.44772 20.5523 8 20 8H13L10.5 5.5H4C3.44772 5.5 3 5.94772 3 6.5V17.5C3 18.0523 3.44772 18.5 4 18.5H20C20.5523 18.5 21 18.0523 21 17.5V15Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <p class="text-sm text-gray-600">Click here to upload (Max 5MB)</p>
                    <input id="image_upload" type="file" name="image" accept="image/*" @change="onFile" class="hidden" {{ $product->exists ? '' : 'required' }} />
                </label>

               <div class="flex items-center justify-center mt-3">
                <div class="h-48 w-48 rounded-xl bg-gray-100 overflow-hidden grid place-content-center border border-gray-300 shadow-sm">
                    <template x-if="preview">
                        <img :src="preview" class="h-48 w-48 object-cover" alt="preview">
                    </template>
                    <template x-if="!preview">
                        <svg class="h-8 w-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 5h16v14H4zM4 15l4-4 4 4 4-3 4 3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </template>
                </div>
            </div>
            </div>
            
        </div>
    </form>
    
    @if(session('status') === 'product-saved')
        <script>
            alert('Product saved successfully!');
            window.location.href = "{{ route('admin.products.index') }}"; 
        </script>
    @endif
    
    </div>
</x-admin-layout>