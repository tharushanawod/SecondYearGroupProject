<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Need support?</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/AddPrices.css">
</head>
<body>
  <?php require 'sidebar.php'; ?>
  <div class="container">
    <!-- <div class="image-container">
        <img src="<?php echo URLROOT;?>/images/helper.png" alt="Support">
    </div> -->
    <div class="form-container">
      <h1>Add Your Pricing</h1>
     
      <form method="POSt" action="">
        <div class="form-group">
          <label for="firstName">Company name</label>
          <input type="text" id="firstName" name="firstName" placeholder="Input text" required>
        </div>
        <div class="form-group">
        <label for="type">Corn type</label>
          <select name="type" id="type">
          <option value="SweeCorn">Sweet Corn</option>
          <option value="DryCorn">Dry Corn</option>
          </select>
        </div>
        <div class="form-group">
          <label for="email">Price</label>
          <input type="number" id="Price" name="price" placeholder="Input Price" required>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>
</body>
</html>