@props([
    'validateUrl'  => route('api.coupons.validate'),
    'totalPrice'   => 0,
    'oldCouponCode'=> old('coupon_code', ''),
])

<div class="mt-6 border border-soft-divider rounded-xl overflow-hidden">
    <div class="bg-faint-gray px-6 py-4 border-b border-soft-divider">
        <h3 class="text-sm font-semibold text-carbon-black">Punya Kode Kupon?</h3>
    </div>
    <div class="p-6">
        <div class="flex gap-2">
            <input
                type="text"
                id="coupon_code_input"
                placeholder="Masukkan kode kupon (contoh: HEMAT50)"
                value="{{ $oldCouponCode }}"
                class="flex-1 border border-soft-divider rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-carbon-black uppercase tracking-widest"
                autocomplete="off"
                spellcheck="false"
                maxlength="50"
            />
            <button
                type="button"
                id="btn-apply-coupon"
                class="px-5 py-2.5 text-sm font-semibold bg-carbon-black text-canvas-white rounded-lg hover:bg-opacity-85 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Terapkan
            </button>
        </div>

        {{-- Feedback area --}}
        <div id="coupon-feedback" class="mt-3 text-sm hidden"></div>

        {{-- Error dari server (jika ada) --}}
        <x-form-error :messages="$errors->get('coupon_code')" />

        {{-- Hidden input yang dikirim ke server --}}
        <input type="hidden" name="coupon_code" id="coupon_code_hidden" value="{{ $oldCouponCode }}" />

        {{-- Data-attr untuk JavaScript --}}
        <div
            id="coupon-meta"
            data-validate-url="{{ $validateUrl }}"
            data-total-price="{{ $totalPrice }}"
            data-csrf="{{ csrf_token() }}"
            class="hidden"
        ></div>
    </div>
</div>

<script>
(function () {
    const input       = document.getElementById('coupon_code_input');
    const btnApply    = document.getElementById('btn-apply-coupon');
    const feedback    = document.getElementById('coupon-feedback');
    const hiddenInput = document.getElementById('coupon_code_hidden');
    const meta        = document.getElementById('coupon-meta');

    if (!input || !btnApply || !meta) return;

    const validateUrl  = meta.dataset.validateUrl;
    const csrf         = meta.dataset.csrf;

    // Fungsi helper: perbarui tampilan ringkasan harga
    // Dipanggil dari luar atau setelah kupon berhasil diaplikasikan
    function updatePriceSummary(discount) {
        if (typeof window.applyDiscountToSummary === 'function') {
            window.applyDiscountToSummary(discount);
        }
    }

    // Jika ada nilai dari old() (validasi gagal server), coba auto-apply
    if (input.value.trim() !== '') {
        // Tidak auto-apply saat page load; biarkan user sadar kupon belum divalidasi ulang
        // (backend sudah menolak dengan error jika kupon invalid)
    }

    btnApply.addEventListener('click', async function () {
        const code = input.value.trim();
        if (!code) {
            showFeedback('Masukkan kode kupon terlebih dahulu.', false);
            return;
        }

        btnApply.disabled = true;
        btnApply.textContent = 'Memeriksa...';
        feedback.classList.add('hidden');

        // Ambil total_price terkini (bisa berubah jika ada perhitungan di halaman)
        let totalPrice = parseFloat(meta.dataset.totalPrice) || 0;
        if (typeof window.getCurrentTotalPrice === 'function') {
            totalPrice = window.getCurrentTotalPrice();
        }

        try {
            const response = await fetch(validateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({ code: code.toUpperCase(), total_price: totalPrice }),
            });

            const data = await response.json();

            if (data.valid) {
                hiddenInput.value = code.toUpperCase();
                input.value = code.toUpperCase();
                showFeedback(data.message, true);
                updatePriceSummary(data.discount);
            } else {
                hiddenInput.value = '';
                showFeedback(data.message, false);
                updatePriceSummary(0);
            }
        } catch (err) {
            showFeedback('Terjadi kesalahan. Silakan coba lagi.', false);
        } finally {
            btnApply.disabled = false;
            btnApply.textContent = 'Terapkan';
        }
    });

    // Enter key pada input juga trigger validasi
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            btnApply.click();
        }
    });

    // Jika user mengubah kode, reset hidden input
    input.addEventListener('input', function () {
        hiddenInput.value = '';
        feedback.classList.add('hidden');
        updatePriceSummary(0);
    });

    function showFeedback(message, isSuccess) {
        feedback.classList.remove('hidden', 'text-green-700', 'text-red-600');
        feedback.classList.add(isSuccess ? 'text-green-700' : 'text-red-600');
        feedback.textContent = (isSuccess ? '✓ ' : '✕ ') + message;
    }
})();
</script>
