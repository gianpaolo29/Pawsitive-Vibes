<div x-cloak x-show="openModal" @keydown.window.escape="openModal = false"
    class="fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
>
    <div @click.away="openModal = false"
        class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto transform transition-all sm:my-8 sm:align-middle"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-bold text-gray-900">GCash Payment Receipt</h3>
                <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <p class="text-sm text-gray-700">**Transaction:** <span x-text="modalData.order_number" class="font-medium text-violet-600"></span></p>
                <p class="text-sm text-gray-700">**Customer:** <span x-text="modalData.customer" class="font-medium"></span></p>
                
                <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                    <p class="text-sm font-semibold text-gray-700">Amount:</p>
                    <p class="text-2xl font-bold text-emerald-600">₱<span x-text="modalData.amount"></span></p>
                </div>
                
                <p class="text-sm text-gray-700">**Reference:** <span x-text="modalData.reference" class="font-medium text-blue-600 break-all"></span></p>
                
                <div class="border p-3 rounded-lg text-center bg-white shadow-inner">
                    <p class="text-xs text-gray-500 mb-2">Customer Uploaded Receipt</p>
                    <a :href="modalData.image_url" target="_blank" title="Click to view full image">
                        <img :src="modalData.image_url" alt="Receipt Proof" 
                            class="max-w-full h-auto rounded-md border border-gray-200 shadow-md mx-auto cursor-pointer object-cover max-h-80" 
                        />
                    </a>
                </div>

                <div class="p-3 bg-orange-50 border-l-4 border-orange-400 text-orange-800 text-sm">
                    <svg class="h-4 w-4 inline-block mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18h20.36L13.71 3.86zM12 9v4M12 17h.01"/></svg>
                    **Validation Required:** Please verify the receipt details match the transaction amount and reference number before accepting the payment.
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <form :action="'{{ url('admin/payments') }}/' + modalData.id + '/reject'" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700 transition duration-150">Reject</button>
                </form>
                <form :action="'{{ url('admin/payments') }}/' + modalData.id + '/accept'" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded text-sm hover:bg-emerald-700 transition duration-150">Accept Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>