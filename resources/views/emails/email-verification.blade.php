<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F7FE;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            width: 300px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #1B254B;
        }

        p {
            margin: 10px 0 20px 0;
            color: #A0AEC0;
        }

        .redirect-message {
            font-weight: bold;
            color: #171923;
        }

    </style>
</head>
<body>
<div class="card">
    @if($is_success)
        <img width="100px" height="100px" src="{{asset('img/success-circle.png')}}" alt="Success">
        <h1>Email Verified!</h1>
        <p>Thank you for verifying your email address.</p>
        <p class="redirect-message">Redirecting in <span id="countdown" class="countdown">5</span> seconds...🎉</p>
    @else
        <h1>Email Verification Failed! ❌</h1>
        <p>Sorry, we could not verify your email address.</p>
    @endif
</div>

<script>
    let countdownValue = 5;
    const countdownElement = document.getElementById('countdown');

    const countdownInterval = setInterval(() => {
        countdownValue--;
        countdownElement.textContent = countdownValue;

        if (countdownValue <= 0) {
            clearInterval(countdownInterval);
            window.location.href = "{{ config('app.client_url') }}";
        }
    }, 1000);
</script>

</body>
</html>
