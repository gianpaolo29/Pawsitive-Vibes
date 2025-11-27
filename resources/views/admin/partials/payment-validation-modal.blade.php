{{-- admin/partials/payment-validation-modal.blade.php --}}
<div
    x-show="openModal"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>
    <div
        @click.away="openModal = false"
        class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6"
    >
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-900">
                Validate GCash Payment
            </h2>
            <button @click="openModal = false" class="p-1 rounded hover:bg-gray-100">
                ✕
            </button>
        </div>

        <div class="space-y-3 text-sm text-gray-700">
            <p><span class="font-semibold">Order #:</span> <span x-text="modalData.order_number"></span></p>
            <p><span class="font-semibold">Customer:</span> <span x-text="modalData.customer"></span></p>
            <p><span class="font-semibold">Amount:</span> ₱<span x-text="modalData.amount"></span></p>
            <p><span class="font-semibold">Reference:</span> <span x-text="modalData.reference"></span></p>

            <template x-if="modalData.image_url">
                <div class="mt-3">
                    <p class="font-semibold mb-1">Receipt Image:</p>
                    <img :src="modalData.image_url.startsWith('http')
                                  ? modalData.image_url
                                  : '/storage/' + modalData.image_url"
                         alt="GCash receipt"
                         class="rounded-lg border max-h-80 object-contain mx-auto">
                </div>
            </template>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button
                type="button"
                @click="openModal = false"
                class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100"
            >
                Close
            </button>

            {{-- Example: approve button – wire to your route --}}
            <form
                method="POST"
                :action="`/admin/orders/${modalData.id}/validate-gcash`"
            >
                @csrf
                @method('PATCH')
                <button
                    type="submit"
                    class="px-4 py-2 text-sm rounded-lg bg-emerald-600 text-white hover:bg-emerald-700"
                >
                    Mark as Paid
                </button>
            </form>
        </div>
    </div>
</div>
