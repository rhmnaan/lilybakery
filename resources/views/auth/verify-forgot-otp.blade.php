<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .card-container {
            max-width: 500px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="card-container">
            <h2 class="mb-4 text-center">Verifikasi OTP</h2>

            <!-- Contoh alert sukses -->
            <!-- <div class="alert alert-success">Kode OTP berhasil dikirim ke email Anda.</div> -->

            <!-- Contoh alert error -->
            <!-- <div class="alert alert-danger">OTP salah atau kadaluarsa.</div> -->

            <form action="/forgot-password/verify-otp" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">

                <div class="mb-3">
                    <label for="otp" class="form-label">Kode OTP</label>
                    <input type="text" name="otp" class="form-control" maxlength="6" required>
                </div>

                <button type="submit" class="btn btn-success">Verifikasi</button>
            </form>



            <form action="/forgot-password/resend-otp" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                <button type="submit" class="btn btn-link">Kirim ulang OTP</button>
            </form>

        </div>
    </div>

</body>
</html>
