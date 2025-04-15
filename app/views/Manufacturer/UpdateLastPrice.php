<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Prices</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/AddPrices.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
  <div class="container">
    <div class="form-container">
      <h1>Update Last Price</h1>
      <form method="POST" action="<?php echo URLROOT; ?>/ManufacturerController/UpdateLastPrice/<?php echo $data['priceid'];?>">
        
        <div class="form-group">
          <label for="date">Date</label>
          <input type="text" id="date" name="date" placeholder="Input Date" value="<?php echo $data['date'];?>" disabled>
        </div>
        <div class="form-group">
          <label for="type">Type</label>
          <input type="text" id="type" name="type" placeholder="Input Type" value="<?php echo $data['type'];?>" disabled>
        </div>
        <div class="form-group">
          <label for="price">Price (Rs)</label>
          <input type="number" id="price" name="price" placeholder="Input Price" value="<?php echo $data['price'];?>" required>
          <span class="form-invalid">
            <?php echo $data['price_err'];?>
        </span>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>
</body>
</html>