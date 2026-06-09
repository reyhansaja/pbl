<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cafe Disetujui</title>
</head>
<body style="font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color:#111827;">
  <div style="max-width:600px;margin:0 auto;padding:20px;">
    <h2 style="margin-bottom:8px;">Selamat — Cafe Anda Disetujui</h2>
    <p style="color:#6b7280">Halo {{ $cafe->owner->name ?? 'Pemilik' }},</p>
    <p style="color:#6b7280">Cafe <strong>{{ $cafe->name }}</strong> telah disetujui dan sekarang tampil di CoffeSpot.</p>
    <p style="color:#6b7280">Anda dapat melihat cafe di: <a href="{{ route('cafe.show', $cafe->slug) }}">Lihat Cafe</a></p>
    <p style="color:#6b7280">Terima kasih telah mendaftar di CoffeSpot.</p>
    <p style="color:#6b7280">Salam,<br/>CoffeSpot Team</p>
  </div>
</body>
</html>
