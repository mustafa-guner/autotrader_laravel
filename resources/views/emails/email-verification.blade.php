<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
</head>
<body>
@if($is_success)
    <h1>Email Verified!</h1>
    <p>Thank you for verifying your email address.</p>
    <p id="redirect-message"><strong>Redirecting..</strong></p>
@else
    <h1>Email Verification Failed!</h1>
    <p>Sorry, we could not verify your email address.</p>
@endif

<script>
    setTimeout(function () {
        if (document.getElementById('redirect-message')) {
            window.location.href = 'http://localhost:8000';
        }
    }, 5000);
</script>
</body>
</html>
