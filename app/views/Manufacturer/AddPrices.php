<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Prices</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/AddPrices.css">
</head>
<body>
  <?php require 'sidebar.php'; ?>
  <div class="container">
    <div class="form-container">
      <h1>Add Your Pricing</h1>
     
      <form method="POSt" action="<?php echo URLROOT; ?>/ManufacturerController/AddPrices">
        <div class="form-group">
        <label for="type">Corn type</label>
          <select name="type" id="type">
          <option value="SweeCorn">Sweet Corn</option>
          <option value="DryCorn">Dry Corn</option>
          </select>
          <span class="form-invalid">
            <?php echo $data['type_err']; ?>
          </span>
        </div>
        <div class="form-group">
          <label for="price">Price (Rs)</label>
          <input type="number" id="price" name="price" placeholder="Input Price" required>
          <span class="form-invalid">
            <?php echo $data['price_err']; ?>
          </span>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>
</body>
</html>