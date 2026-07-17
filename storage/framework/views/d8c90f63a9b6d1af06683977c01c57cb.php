<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Bot QR</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl text-center max-w-sm w-full">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Monitor WA Bot</h1>
        <p class="text-slate-500 mb-6 text-sm">Scan QR ini dari aplikasi WhatsApp Anda (Perangkat Tertaut) untuk
            mengaktifkan bot WhatsApp API.</p>

        <div id="qrcode" class="flex justify-center p-4 bg-slate-100 rounded-xl mb-6 min-h-[250px] items-center">
            <?php if($qr): ?>
                <script>
                    setTimeout(() => {
                        new QRCode(document.getElementById("qrcode"), {
                            text: "<?php echo addslashes($qr); ?>",
                            width: 250,
                            height: 250,
                            colorDark: "#0f172a",
                            colorLight: "transparent",
                            correctLevel: QRCode.CorrectLevel.L
                        });
                        document.querySelector('#qrcode').classList.remove('items-center');
                    }, 100);
                </script>
            <?php else: ?>
                <p class="text-emerald-600 font-semibold text-lg flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Bot WhatsApp Aktif!
                </p>
            <?php endif; ?>
        </div>

        <?php if($qr): ?>
            <p class="text-xs text-slate-400">QR Code berganti otomatis. Refresh halaman ini jika <i>Expired</i>.</p>
        <?php endif; ?>
    </div>
</body>

</html><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/pages/wa-qr.blade.php ENDPATH**/ ?>