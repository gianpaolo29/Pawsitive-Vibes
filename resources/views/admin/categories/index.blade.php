<x-admin-layout title="Categories">
    {{-- SweetAlert2 CDN (Include this in your <head> or layout file) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- Important: Ensure your main layout has this meta tag for security --}}
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <div class="flex flex-col gap-6" x-data="categoryManager()">

        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
        </div>

        {{-- Start of the Two-Section Grid Layout --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 xl:grid-cols-4">

            {{-- Left Section: Dynamic Form --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800" x-text="formTitle">
                        Create New Category
                    </h2>
                    
                    {{-- The form action and method are now dynamic based on the Alpine state --}}
                    <form x-bind:action="formAction" method="POST" id="category-form">

                        @csrf
                        
                        {{-- Add @method('PUT') only when editing --}}
                        <template x-if="isEditMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        {{-- Category ID (Hidden field for reference if needed) --}}
                        <input type="hidden" name="category_id" x-model="categoryId">

                        {{-- Name Field --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                            <input type="text" id="name" name="name" required x-model="categoryName"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-violet-500 focus:ring-violet-500">
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit"
                            class="w-full text-white px-4 py-2 rounded-lg text-sm font-medium"
                            :class="isEditMode ? 'bg-amber-500 hover:bg-amber-600' : 'bg-violet-600 hover:bg-violet-700'">
                            <span x-text="buttonText">Save Category</span>
                        </button>
                        
                        {{-- Cancel/Reset Button --}}
                        <template x-if="isEditMode">
                            <button type="button" @click="resetForm()"
                                class="w-full mt-2 bg-gray-400 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-500 font-medium">
                                Cancel Edit
                            </button>
                        </template>
                    </form>
                </div>
            </div>
            {{-- End of Left Section: Dynamic Form --}}

            {{-- Right Section: Table --}}
            <div class="lg:col-span-2 xl:col-span-3">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <table class="min-w-full text-sm divide-y divide-gray-100">
                        <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Category Name</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($categories as $c)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $c->id }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $c->name }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        
                                        {{-- Edit: Use JavaScript to populate the form --}}
                                        <a href="#" @click.prevent="editCategory({{ $c->id }}, '{{ $c->name }}')"
                                            class="text-amber-500 hover:text-amber-600 font-medium">Edit</a>

                                        {{-- Delete: Use SweetAlert and dynamic form submission --}}
                                        <button @click="confirmDelete('{{ route('admin.categories.destroy', $c) }}')"
                                            class="text-rose-600 hover:text-rose-700 font-medium">Delete</button>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-10 text-center text-gray-500">
                                    No categories found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="px-4 py-3 border-t border-gray-100">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
            {{-- End of Right Section: Table --}}

        </div>
        {{-- End of the Two-Section Grid Layout --}}

    </div>

    {{-- JavaScript & Alpine.js Logic --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('categoryManager', () => ({
                // Alpine State
                isEditMode: false,
                categoryId: null,
                categoryName: '',
                defaultAction: '{{ route('admin.categories.store') }}',

                // Computed Properties
                get formTitle() {
                    return this.isEditMode ? 'Edit Category' : 'Create New Category';
                },
                get buttonText() {
                    return this.isEditMode ? 'Update Category' : 'Save Category';
                },
                                get formAction() {
                    if (this.isEditMode) {
                        return `/admin/categories/${this.categoryId}`;
                    }
                    return `{{ route('admin.categories.store') }}`;
                },


                // Functions
                editCategory(id, name) {
                    this.isEditMode = true;
                    this.categoryId = id;
                    this.categoryName = name;
                    
                    // Scroll to the form for better UX and focus on the input
                    document.getElementById('category-form').scrollIntoView({ behavior: 'smooth' });
                    document.getElementById('name').focus();
                },

                resetForm() {
                    this.isEditMode = false;
                    this.categoryId = null;
                    this.categoryName = '';
                },

                confirmDelete(deleteUrl) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626', // rose-600
                        cancelButtonColor: '#6b7280', // gray-500
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a temporary form to submit the DELETE request
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = deleteUrl;
                            
                            // Get CSRF token from the global meta tag or the Blade directive
                            const csrfTokenElement = document.querySelector('meta[name="csrf-token"]') || document.querySelector('input[name="_token"]');
                            const csrfValue = csrfTokenElement ? csrfTokenElement.content || csrfTokenElement.value : '{{ csrf_token() }}';

                            // Add CSRF token
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfValue;
                            form.appendChild(csrfInput);

                            // Add DELETE method spoofing
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    })
                }
            }));
        });
    </script>
    
    {{-- SweetAlert Flash Message Handling --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            })
        </script>
    @endif
</x-admin-layout>