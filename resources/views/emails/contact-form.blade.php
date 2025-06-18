<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru dari Formulir Kontak Lily Bakery</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; }
        h1 { color: #333; font-size: 24px; margin-bottom: 20px; }
        p { margin-bottom: 10px; }
        strong { color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pesan Baru dari Formulir Kontak Lily Bakery</h1>
        <p>Anda menerima pesan baru dari formulir kontak website Anda:</p>
        <p><strong>Nama Lengkap:</strong> {{ $namaLengkap }}</p>
        <p><strong>Nomor Telepon:</strong> {{ $nomorTelepon }}</p>
        <p><strong>Email:</strong> {{ $emailPengirim }}</p>
        <p><strong>Pesan:</strong></p>
        <p style="white-space: pre-wrap; background-color: #eee; padding: 10px; border-radius: 5px;">{{ $pesanKontak }}</p>
        <p>---</p>
        <p>Email ini dikirim otomatis. Jangan membalas email ini secara langsung. Balas email pengirim ($emailPengirim) jika ingin membalas pesan.</p>
    </div>
</body>
</html>