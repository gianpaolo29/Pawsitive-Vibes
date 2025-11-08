@php
    $isEdit = isset($customer) && $customer !== null;
    $title  = $isEdit ? 'Edit Customer' : 'Add New Customer';
    $action = $isEdit
        ? route('admin.customers.update', $customer)
        : route('admin.customers.store');
@endphp

<x-admin-layout>
    <div class="flex flex-col gap-6">

        <div class="sticky top-0 z-10 bg-white border-b border-gray-200 py-3 px-4 sm:px-6 -mx-4 sm:-mx-6 lg:-mx-8
                    flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900 ml-4 sm:ml-0">{{ $title }}</h1>
            <div class="flex items-center gap-3 mr-4 sm:mr-0">
                <a href="{{ route('admin.customers.index') }}"
                   class="px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                    Cancel
                </a>
                <button type="submit" form="customer-form"
                        class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700 font-semibold shadow-md">
                    {{ $isEdit ? 'Update Customer' : 'Save Customer' }}
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-red-300 bg-red-50 p-4 text-sm text-red-700 mx-auto max-w-7xl">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="customer-form" method="POST" action="{{ $action }}"
              class="grid grid-cols-1 gap-6 pt-2"> 
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div class="bg-white rounded-xl shadow-lg p-6 space-y-5 border-t-4 border-violet-600">

                <h3 class="text-lg font-bold text-gray-900 border-b pb-3 -mx-6 px-6">Basic Credentials</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-gray-700">
                            First Name <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" id="first_name" name="first_name"
                               value="{{ old('first_name', $customer->fname ?? '') }}" required
                               placeholder="Enter customer first name"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                        @error('first_name') <div class="text-rose-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-gray-700">
                            Last Name <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" id="last_name" name="last_name"
                               value="{{ old('last_name', $customer->lname ?? '') }}" required
                               placeholder="Enter customer last name"
                               class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                        @error('last_name') <div class="text-rose-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            Email Address <span class="text-rose-600">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $customer->email ?? '') }}" required
                            placeholder="customer@example.com"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                        @error('email') <div class="text-rose-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700">
                            Username <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" id="username" name="username"
                            value="{{ old('username', $customer->username ?? '') }}" required
                            placeholder="Choose a unique username"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                        @error('username') <div class="text-rose-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                </div> 

                <div class="border-t pt-5 mt-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            {{ $isEdit ? 'New Password (optional)' : 'Password' }}{{ $isEdit ? '' : ' *' }}
                        </label>
                        <input type="password" id="password" name="password"
                            {{ $isEdit ? '' : 'required' }}
                            placeholder="{{ $isEdit ? 'Leave blank to keep current password' : 'Set a strong password' }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                        @error('password') <div class="text-rose-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                            Confirm Password{{ $isEdit ? ' (optional)' : ' *' }}
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            {{ $isEdit ? '' : 'required' }}
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-violet-500 focus:border-violet-500" />
                        @error('password_confirmation') <div class="text-rose-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                </div> 

            </div>
        </form>
    </div>
</x-admin-layout>