<div 
    x-cloak 
    x-show="openModal"
    class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 p-4"
    x-transition.opacity
>
    <div 
        class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden"
        @click.away="openModal = false"
        x-transition.scale
    >
        <!-- HEADER -->
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">
                Validate GCash Payment
            </h2>
            <button 
                class="p-2 rounded hover:bg-gray-100"
                @click="openModal = false"
            >
                <i class="fa-solid fa-xmark text-gray-600"></i>
            </button>
        </div>

        <!-- BODY -->
        <div class="p-5 space-y-4">
            <div class="text-sm">
                <p class="font-semibold text-gray-800">Order Number:</p>
                <p class="text-gray-700" x-text="modalData.order_number"></p>
            </div>

            <div class="text-sm">
                <p class="font-semibold text-gray-800">Customer:</p>
                <p class="text-gray-700" x-text="modalData.customer"></p>
            </div>

            <div class="text-sm">
                <p class="font-semibold text-gray-800">Amount:</p>
                <p class="text-gray-700">₱ <span x-text="modalData.amount"></span></p>
            </div>

            <div class="text-sm">
                <p class="font-semibold text-gray-800">GCash Reference Number:</p>
                <p class="text-gray-700" x-text="modalData.reference"></p>
            </div>

            <template x-if="modalData.image_url">
                <div>
                    <p class="font-semibold text-gray-800 mb-1">Receipt:</p>
                    <img 
                        :src="modalData.image_url" 
                        alt="GCash Receipt"
                        class="w-full max-h-80 object-contain rounded-lg border"
                    >
                </div>
            </template>
        </div>

        <!-- FOOTER BUTTONS -->
        <div class="p-4 border-t flex items-center justify-end gap-3 bg-gray-50">
            
            <!-- Reject -->
            <form 
                method="POST" 
                :action="'/admin/orders/' + modalData.id + '/reject-payment'"
            >
                @csrf
                @method('PUT')
                <button 
                    type="submit"
                    class="px-4 py-2 text-sm font-semibold text-red-600 bg-red-100 rounded-lg hover:bg-red-200"
                >
                    Reject
                </button>
            </form>

            <!-- Accept -->
            <form 
                method="POST" 
                :action="'/admin/orders/' + modalData.id + '/accept-payment'"
            >
                @csrf
                @method('PUT')
                <button 
                    type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700"
                >
                    Accept
                </button>
            </form>

            <!-- Close -->
            <button 
                class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300"
                @click="openModal = false"
            >
                Close
            </button>
        </div>
    </div>
</div>
