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
        <div class="logo"><a href="<?php echo URLROOT;?>/LandingController/index"><img src="<?php echo URLROOT; ?>/images/logo.png" alt="" style="width:150px;"></a></div>
            <div class="icons-container">
                <div class="icon icon-1"></div>
                <div class="icon icon-2"></div>
                <div class="icon icon-3"></div>
            </div>
            <h1 class="typing"> Register As A Worker</h1>
            <p>Register now to connect with trusted farmers, find reliable job opportunities, and contribute to thriving corn farms across Sri Lanka. Enjoy fair wages, flexible work options, and a supportive community. Start your journey with Corn Cradle today!</p>
        </div>
        <div class="form-container">
            <form action="<?php echo URLROOT;?>/LandingController/signup" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_type" value="farmworker">
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" id="name" name="name" placeholder="Example Name" value="<?php echo $data['name'];?>" required>
                    <span class="form-invalid">
                        <?php echo $data['name_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email"  name="email" placeholder="Enter email" value="<?php echo $data['email'];?>">
                    <span class="form-invalid">
                        <?php echo $data['email_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter phone number" 
                                value="<?php echo $data['phone'];?>" 
                                pattern="0\d{9}" 
                                title="Phone number must start with 0 and be exactly 10 digits.">
                
                                <span class="form-invalid">
                            <?php echo $data['phone_err']; ?>
                        </span>
                </div> 

              

                

                <div class="form-group">
                    <label for="working_area">Working Area</label>
                    <select name="working_area" id="working_area">
                        <option value="Colombo">Colombo</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Kalutara">Kalutara</option>
                        
                        <option value="Matale">Matale</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Galle">Galle</option>
                        <option value="Matara">Matara</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Vavuniya">Vavuniya</option>
                        
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Ampara">Ampara</option>
                        <option value="Trincomalee">Trincomalee</option>
                        
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
                    <span class="form-invalid">
                        <?php echo $data['working_area_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="skills">Skills</label>
                    <div id="skills">
                        <label><input type="checkbox" name="skills[]" value="Operating Machinery"> Operating Machinery</label><br>
                        <label><input type="checkbox" name="skills[]" value="Maintaining Crops"> Maintaining Crops</label><br>
                        <label><input type="checkbox" name="skills[]" value="Harvesting"> Harvesting</label><br>
                        <label><input type="checkbox" name="skills[]" value="Planting"> Planting</label>
                    </div>
                    <span class="form-invalid">
                        <?php echo $data['skills_err']; ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="hourly_rate">Hourly Rate</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" placeholder="Enter hourly rate" value="<?php echo $data['hourly_rate']; ?>"  min="0">
                    <span class="form-invalid">
                        <?php echo $data['hourly_rate_err']; ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter At least 8 characters" minlength="8" value="<?php echo $data['password'];?>">
                    <span class="form-invalid">
                        <?php echo $data['password_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Re Type Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Enter At least 8 characters" minlength="8" value="<?php echo $data['confirm_password'];?>">
                    <span class="form-invalid">
                        <?php echo $data['confirm_password_err'];?>
                    </span>
                </div>

                <button type="submit" class="signup-btn">Sign up</button>
                <p class="login-text">Been here before? <a href="<?php echo URLROOT;?>/LandingController/Login">Log in</a></p>
            </form>
        </div>
    </div>
</body>
</html>