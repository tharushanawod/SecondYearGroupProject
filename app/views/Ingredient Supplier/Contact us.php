<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Need support?</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Contact us.css">
</head>
<body>
  <?php require 'sidebar.php'; ?>
  <div class="container">
    <!-- <div class="image-container">
        <img src="<?php echo URLROOT;?>/images/helper.png" alt="Support">
    </div> -->
    <div class="form-container">
      <h1>Need support?</h1>
      <p>Fill in the form to get in touch.</p>
      <form>
        <div class="form-group">
          <label for="firstName">First name</label>
          <input type="text" id="firstName" name="firstName" placeholder="Input text" required>
        </div>
        <div class="form-group">
          <label for="lastName">Last name</label>
          <input type="text" id="lastName" name="lastName" placeholder="Input text" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Input text" required>
        </div>
        <div class="form-group">
          <label for="topic">Which topic best fit your needs?</label>
          <input type="text" id="topic" name="topic" placeholder="Input text" required>
        </div>
        <div class="form-group">
          <label for="message">How can we help?</label>
          <textarea id="message" name="message" placeholder="Please share what you want us to help" required></textarea>
        </div>
        <button type="submit">Send</button>
      </form>
    </div>
  </div>
</body>
</html>