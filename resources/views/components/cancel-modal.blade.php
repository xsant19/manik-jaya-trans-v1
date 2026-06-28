<!-- Cancel Booking Modal -->
<div id="cancel-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background backdrop -->
    <div class="fixed inset-0 bg-carbon-black bg-opacity-50 transition-opacity backdrop-blur-sm"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-xl bg-canvas-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-canvas-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-bold leading-6 text-carbon-black" id="modal-title">Batalkan Pesanan</h3>
                            <div class="mt-2">
                                <p class="text-sm text-storm-gray">Apakah Anda yakin ingin membatalkan pesanan ini? Pesanan yang telah dibatalkan tidak dapat dikembalikan, dan Anda harus membuat pesanan baru jika berubah pikiran.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-faint-gray px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="confirm-cancel-btn" class="inline-flex w-full justify-center rounded-btn bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors sm:ml-3 sm:w-auto">Ya, Batalkan</button>
                    <button type="button" onclick="closeCancelModal()" class="mt-3 inline-flex w-full justify-center rounded-btn bg-canvas-white px-4 py-2 text-sm font-medium text-carbon-black border border-soft-divider hover:bg-faint-gray transition-colors sm:mt-0 sm:w-auto">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let activeCancelForm = null;

    function openCancelModal(formId) {
        activeCancelForm = document.getElementById(formId);
        document.getElementById('cancel-modal').classList.remove('hidden');
    }

    function closeCancelModal() {
        activeCancelForm = null;
        document.getElementById('cancel-modal').classList.add('hidden');
    }

    document.getElementById('confirm-cancel-btn')?.addEventListener('click', function() {
        if (activeCancelForm) {
            this.disabled = true;
            this.innerHTML = 'Memproses...';
            activeCancelForm.submit();
        }
    });
</script>
