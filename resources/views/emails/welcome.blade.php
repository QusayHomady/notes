<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>رمز التحقق</title>
</head>
<body>
    <h2>مرحبًا {{ $user->name }}</h2>
    <p>شكرًا لتسجيلك في تطبيقنا.</p>
    <p>رمز التحقق الخاص بك هو:</p>
    <h1 style="color: #045cb4;">{{ $verifyCode }}</h1>
    <p>يرجى إدخاله في التطبيق لتفعيل حسابك.</p>
</body>
</html>
