<?php

/**
 * Konfigurasi Informasi Perusahaan — Manik Jaya Trans
 *
 * BEST PRACTICE:
 * - Data statis seperti nama, alamat, kontak → simpan di config (file ini).
 * - Data yang perlu diubah admin tanpa deploy → pertimbangkan Filament Settings.
 * - Untuk proyek ini, config sudah cukup karena data perusahaan jarang berubah.
 *
 * Cara akses di Blade: {{ config('company.phone_wa_link') }}
 * Cara akses di PHP  : config('company.name')
 */

return [

    // ─── Identitas ────────────────────────────────────────────────────────────
    'name'        => 'Manik Jaya Trans',
    'tagline'     => 'Penyedia layanan transportasi wisata dan sewa kendaraan terpercaya di Bali.',

    // ─── Alamat ───────────────────────────────────────────────────────────────
    'address'     => 'Gg. Jeruk No.9a, Tonja, Kec. Denpasar Utara, Kota Denpasar, Bali 80235',
    'city'        => 'Denpasar, Bali',

    // ─── Kontak ───────────────────────────────────────────────────────────────
    'phone'       => '0895-3934-91819',
    'phone_intl'  => '62895393491819',   // format internasional untuk wa.me (tanpa + dan tanpa tanda hubung)
    'email'       => 'manikjayatrans@gmail.com',

    // ─── WhatsApp ─────────────────────────────────────────────────────────────
    'wa_message'  => 'Halo%20Manik%20Jaya%20Trans%2C%20saya%20ingin%20bertanya%20seputar%20layanan%20transportasi.',
    'wa_link'     => 'https://wa.me/62895393491819?text=Halo%20Manik%20Jaya%20Trans%2C%20saya%20ingin%20bertanya%20seputar%20layanan%20transportasi.',

    // ─── Google Maps ──────────────────────────────────────────────────────────
    // Link share asli: https://share.google/X2ahHilsWiEoZg7q9
    // Untuk embed iframe, kita butuh URL format /embed — gunakan koordinat lokasi
    // atau URL embed dari Google Maps "Share > Embed a map".
    // CATATAN: Link share.google tidak bisa langsung di-embed. Gunakan URL embed resmi:
    'maps_share_url' => 'https://share.google/X2ahHilsWiEoZg7q9',
    'maps_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.5!2d115.2154!3d-8.6478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23d4b5a5a5a5a%3A0x0!2sGg.%20Jeruk%20No.9a%2C%20Tonja%2C%20Denpasar%20Utara%2C%20Denpasar%2C%20Bali%2080235!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',

    // ─── Jam Operasional ──────────────────────────────────────────────────────
    'hours'       => 'Senin – Minggu, 07:00 – 22:00 WITA',

    // ─── Sosial Media (siap dipakai jika ada di masa depan) ──────────────────
    'social' => [
        'instagram' => null,
        'facebook'  => null,
        'tiktok'    => null,
    ],

];
