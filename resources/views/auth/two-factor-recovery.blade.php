<x-app-layout>
    <div class="py-10 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-lg mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-6 text-center">
                    <div class="text-3xl mb-2">🔑</div>
                    <h1 class="text-xl font-bold text-white">Recovery Codes</h1>
                    <p class="text-amber-100 text-sm mt-1">Use these if you lose access to your authenticator app</p>
                </div>

                <div class="p-6">
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 mb-5">
                        <p class="text-xs text-amber-800 dark:text-amber-300">
                            Each code can only be used <strong>once</strong>. After using a recovery code, it will be permanently removed. Keep these somewhere safe.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-6">
                        @forelse($codes as $code)
                            <code class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-xl text-sm font-mono font-bold text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600 text-center">{{ $code }}</code>
                        @empty
                            <p class="col-span-2 text-center text-sm text-gray-500 py-4">No recovery codes remaining. Consider regenerating them.</p>
                        @endforelse
                    </div>

                    <div class="text-center">
                        <a href="{{ route('customer.profile') }}"
                           class="inline-flex items-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition">
                            &larr; Back to Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
