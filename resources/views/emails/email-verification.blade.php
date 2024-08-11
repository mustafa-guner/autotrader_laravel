<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification / E-Posta Doğrulama</title>
</head>
<body>
@if($is_success)
    <h1>Email Verified! / E-Posta Doğrulandı!</h1>
    <p>Thank you for verifying your email address. / E-posta adresinizi doğruladığınız için teşekkür ederiz.</p>
    <p id="redirect-message"><strong>Redirecting..</strong> / <strong>Yönlendiriliyor..</strong></p>
@else
    <h1>Email Verification Failed! / E-Posta Doğrulama Başarısız!</h1>
    <p>Sorry, we could not verify your email address. / Üzgünüz, e-posta adresinizi doğrulayamadık.</p>
@endif

<script>
    setTimeout(function () {
        if (document.getElementById('redirect-message')) {
            window.location.href = 'http://localhost:3000';
        }
    }, 5000);
</script>
</body>
</html>
