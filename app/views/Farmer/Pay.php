<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/payment.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
  <div class="payment-container">

  <div class="header">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
        <path d="M512 80c8.8 0 16 7.2 16 16l0 32L48 128l0-32c0-8.8 7.2-16 16-16l448 0zm16 144l0 192c0 8.8-7.2 16-16 16L64 432c-8.8 0-16-7.2-16-16l0-192 480 0zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm56 304c-13.3 0-24 10.7-24 24s10.7 24 24 24l48 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-48 0zm128 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-112 0z"/>
      </svg>
      <h2>Payment method</h2>
    </div>
    <p class="subtitle">Select a payment method</p>

    <div class="payment-options">
      <label class="payment-option">
        <input type="radio" name="payment" checked>
        <img width="48" height="48" src="https://img.icons8.com/color/48/visa.png" alt="visa"/>
      </label>
      <label class="payment-option">
        <input type="radio" name="payment">
        <img width="48" height="48" src="https://img.icons8.com/color/48/mastercard-logo.png" alt="mastercard-logo"/>
      </label>
    </div>

    <div class="form-grid">
      <div class="form-field">
        <label>Name on card</label>
        <input type="text" placeholder="Enter name on card">
      </div>
      <div class="form-field">
        <label>Card number</label>
        <input type="text" placeholder="Enter card number">
      </div>
      <div class="form-field">
        <label>Expiration date</label>
        <select>
          <option>MM/YY</option>
        </select>
      </div>
      <div class="form-field">
        <label>CVV</label>
        <input type="text" placeholder="Enter CVV">
      </div>
    </div>

    <div class="checkbox-field">
      <input type="checkbox" id="sameAddress">
      <label for="sameAddress">Use same address as billing info</label>
    </div>

    <div class="form-grid">
      <div class="form-field-full-width">
        <label>Address</label>
        <input type="text" placeholder="Add address">
      </div>
      <div class="form-field">
        <label>Zip/Postal code</label>
        <input type="text" placeholder="Input code">
      </div>
      <div class="form-field">
        <label>Country/Region</label>
        <select>
          <option>Select country/region</option>
        </select>
     
      </div>
    
    </div>

    <button class="save-button">Pay Now</button>
  </div>
</body>
</html>