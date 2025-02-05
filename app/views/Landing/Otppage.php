<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Otppage.css">
</head>
<body>
    <div class="container">
        <h1>OTP Verification</h1>
        <div class="button-group">
            <form id="myForm">
                <input type="hidden" name="send_otp" value="SEND_OTP">
            <button id="sendOtpBtn" type="submit">Send OTP</button>
            </form>
        </div>

        <div id="response"></div>


        <div id="inputform" class="otp-form">
            <div class="otp-input">

            <form id="verifyForm">

                <input type="text"  name="code"  />
             
                <button id="verifyBtn" type="submit">Verify</button>
            

            </form>
                
            </div>
           
            <div id="timer" class="timer"></div>
        </div>
    </div>

    <script>
    const URLROOT = '<?php echo URLROOT; ?>';
</script>
<script src="<?php echo URLROOT; ?>/js/Testing.js"></script>

</body>
</html>