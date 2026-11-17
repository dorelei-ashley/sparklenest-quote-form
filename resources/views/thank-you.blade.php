<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank You | SparkleNest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        :root { --teal: #14A39A; --navy: #0F2A3D; --yellow: #FFC857; --mint: #F6FBFA; --gray: #4A5B68; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--navy);
            background: var(--mint);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }
        .card {
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 16px;
            padding: 36px 28px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(15, 42, 61, 0.10);
        }
        .logo { font-family: 'Poppins', sans-serif; color: var(--teal); font-size: 20px; margin: 0 0 20px; }
        .pill { display: inline-block; background: #E3F5F3; color: var(--teal); font-size: 13px; font-weight: 600; padding: 6px 12px; border-radius: 999px; margin-bottom: 16px; }
        h1 { font-family: 'Poppins', sans-serif; font-size: 28px; margin: 0 0 8px; }
        p { color: var(--gray); font-size: 16px; line-height: 1.5; }
        .badge { display: inline-block; background: #FFF3D6; color: var(--navy); font-size: 14px; padding: 8px 14px; border-radius: 10px; margin: 8px 0 20px; }
        .btn { display: inline-block; background: var(--yellow); color: var(--navy); font-weight: 600; text-decoration: none; padding: 14px 24px; border-radius: 12px; }
    </style>
</head>
<body>
    <main class="card">
        <p class="logo">SparkleNest ✨</p>
        <span class="pill">✓ Quote request received</span>
        <h1>You're All Set{{ session('first_name') ? ', ' . e(session('first_name')) : '' }}! 🎉</h1>
        <p>We're preparing your quote now. Check your email, and we'll text you shortly.</p>
        <div class="badge">Your $25 discount is applied automatically.</div>
        <br>
        <a class="btn" href="{{ route('quote.form') }}">Back to form</a>
    </main>
</body>
</html>