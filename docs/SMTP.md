# Local SMTP (Gmail)

To send OTP emails via Gmail SMTP, add the following to your `.env` (do NOT commit `.env`):

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="CoffeSpot"
```

Important: For Gmail, create an App Password (recommended) or enable "Less secure app access" on older accounts. Prefer App Passwords with 2FA.

After updating `.env`, run:

```bash
php artisan config:clear
php artisan migrate
```

Routes added:
- `GET /password/otp` — request OTP
- `POST /password/otp` — send OTP email
- `GET /password/otp/verify` — enter OTP
- `POST /password/otp/verify` — verify OTP
- `GET /password/otp/reset` — set new password
- `POST /password/otp/reset` — update password
