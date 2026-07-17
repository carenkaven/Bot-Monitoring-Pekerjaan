<?php $status = $status ?? 'Menunggu'; ?>
<?php if($status === 'Disetujui'): ?>
    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4L8 12.6l7.3-7.3a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
        Disetujui
    </span>
<?php elseif($status === 'Ditolak'): ?>
    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.3 4.3a1 1 0 011.4 0L10 8.6l4.3-4.3a1 1 0 111.4 1.4L11.4 10l4.3 4.3a1 1 0 01-1.4 1.4L10 11.4l-4.3 4.3a1 1 0 01-1.4-1.4L8.6 10 4.3 5.7a1 1 0 010-1.4z" clip-rule="evenodd"/></svg>
        Ditolak
    </span>
<?php else: ?>
    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.7-12a.7.7 0 10-1.4 0v4c0 .2.1.4.2.5l2.5 2.5a.7.7 0 001-1L10.7 9.7V6z" clip-rule="evenodd"/></svg>
        Menunggu
    </span>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/partials/status-badge.blade.php ENDPATH**/ ?>