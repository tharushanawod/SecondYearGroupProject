<!DOCTYPE html>
<html lang="en">
 <head>
  <title>
   Profile
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/ManageProfile.css">
 </head>
 <body>
 <?php require 'sidebar.php' ?>
  <div class="container">
   <div class="profilesidebar">
    <img alt="Profile picture of Jay Rutherford" height="100" src="<?php echo URLROOT;?>/images/man.jpg" width="100"/>
    <div class="edit-icon">
     <i class="fas fa-pencil-alt">
     </i>
    </div>
    <h2>
   <?php echo $_SESSION['user_name']; ?>
    </h2>
    <p>
   <?php echo $_SESSION['user_role']; ?>
    </p>
   </div>
   <div class="content">
    <h1>
     Settings
    </h1>
    <div class="tabs">
     <a class="active" href="#">
      General
     </a>
    </div>
    <h2>
     Profile
    </h2>
    <div class="form-group">
     <div>
      <label for="name">
       Name
      </label>
      <input id="name" placeholder="Your full name" type="text"/>
     </div>
     <div>
      <label for="contact">
       Contact Number
      </label>
      <input id="contact" placeholder="Your number" type="text"/>
     </div>
    </div>
    <div class="form-group full-width">
     <label for="address">
      Address
     </label>
     <input id="address" placeholder="Your address" type="text"/>
    </div>
    <hr/>
    <h2>
     Account
    </h2>
    <div class="form-group">
     <div>
      <label for="email">
       Email
      </label>
      <input id="email" placeholder="example.email@gmail.com" type="email"/>
     </div>
     <div>
      <label for="password">
       Password
      </label>
      <input id="password" placeholder="********" type="password"/>
     </div>
    </div>
    <button class="save-btn">
     Save information
    </button>
   </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
    const billingsTab = document.querySelector('a[href="#"]:nth-child(2)'); // Second <a> element
    const contentDiv = document.querySelector(".content");

    const billingHTML = `
        <div class="tcontainer">
           <div class="alert">
              <i class="fas fa-exclamation-circle"></i>
              Having a bank account enables you to make various payment transactions
           </div>
           <div class="section">
              <div class="section-title">
                 <i class="fas fa-university"></i>
                 Bank account
              </div>
              <div class="form-group">
                 <div class="form-control">
                    <label for="bank-name">Bank name</label>
                    <select id="bank-name">
                       <option>Bank name</option>
                       <option>Bank of Ceylon</option>
                       <option>People's Bank</option>
                       <option>Commercial Bank of Ceylon</option>
                       <option>Hatton National Bank</option>
                       <option>Sampath Bank</option>
                       <option>National Savings Bank</option>
                       <option>Seylan Bank</option>
                       <option>Union Bank of Colombo</option>
                       <option>DFCC Bank</option>
                       <option>NDB Bank</option>
                       <option>Pan Asia Bank</option>
                       <option>Cargills Bank</option>
                       <option>Amana Bank</option>
                       <option>HSBC Sri Lanka</option>
                       <option>Standard Chartered Bank</option>
                       <option>Citibank Sri Lanka</option>
                    </select>
                 </div>
                 <div class="form-control">
                    <label for="account-number">Account number</label>
                    <input id="account-number" placeholder="Account number" type="text"/>
                 </div>
                 <div class="form-control">
                    <label for="confirm-account-number">Confirm account number</label>
                    <input id="confirm-account-number" placeholder="Account number" type="text"/>
                 </div>
              </div>
           </div>
           <div class="section">
              <div class="section-title">
                 <i class="fas fa-credit-card"></i>
                 Personal account
              </div>
              <div class="payment-methods">
                 <div class="payment-method selected">
                    <img alt="VISA" height="30" src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" width="50"/>
                    <img alt="MasterCard" height="30" src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" width="50"/>
                 </div>
              </div>
              <div class="form-group">
                 <div class="form-control">
                    <label for="name-on-card">Name on card</label>
                    <input id="name-on-card" placeholder="Enter name on card" type="text"/>
                 </div>
                 <div class="form-control">
                    <label for="card-number">Card number</label>
                    <input id="card-number" placeholder="Enter card number" type="text"/>
                 </div>
                 <div class="form-control">
                 <label for="month-year">Select Month and Year:</label>
<input type="month" id="month-year" name="month-year">
                 </div>
                 <div class="form-control">
                    <label for="cvv">CVV</label>
                    <input id="cvv" placeholder="Enter CVV" type="text"/>
                 </div>
              </div>
           </div>
           <a href="<?php echo URLROOT;?>/FarmerController/ManageProfile">
           <button class="btn">
              Save
              <i class="fas fa-arrow-right"></i>
           </button>
           </a>
        </div>
    `;

    billingsTab.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the default link behavior
        contentDiv.innerHTML = billingHTML;
    });
});

  </script>
 </body>
</html>