<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Registration</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Register.css">
</head>
<body>
   
    <div class="container">
        <div class="left-section">
        <div class="logo"><img src="<?php echo URLROOT; ?>/images/logo.png" alt="" style="width:150px;"></div>
            <div class="icons-container">
                <div class="icon icon-1"></div>
                <div class="icon icon-2"></div>
                <div class="icon icon-3"></div>
            </div>
            <h1 class="typing"> Register As A Worker</h1>
            <p>Register now to connect with trusted farmers, find reliable job opportunities, and contribute to thriving corn farms across Sri Lanka. Enjoy fair wages, flexible work options, and a supportive community. Start your journey with Corn Cradle today!</p>
        </div>
        <div class="form-container">
            <form>
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" id="name" placeholder="Example Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="example.email@gmail.com" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" placeholder="ex:- 07-xxxxxxxx" required>
                </div> 

                <div class="form-group">
                    <label for="district">Working Area</label>
                    <select name="district" id="district">
                        <option value="Colombo">Colombo</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Matale">Matale</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Galle">Galle</option>
                        <option value="Matara">Matara</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Vavuniya">Vavuniya</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Ampara">Ampara</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Monaragala">Monaragala</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Kegalle">Kegalle</option>
                        <option value="Sabaragamuwa">Sabaragamuwa</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Kandy">Kandy</option>
                    </select>
                    
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-field">
                        <input type="password" id="password" placeholder="Enter at least 8+ characters" minlength="8" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Re Type Password</label>
                    <div class="password-field">
                        <input type="password" id="confirm-password" placeholder="Retype your password" minlength="8" required>
                    </div>
                </div>

                <button type="submit" class="signup-btn">Sign up</button>
                <p class="login-text">Been here before? <a href="#">Log in</a></p>
            </form>
        </div>
    </div>
</body>
</html>