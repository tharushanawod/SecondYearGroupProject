<html>

<head>
   <title>Settings</title>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
   <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/ManageProfile.css" />
</head>

<body>
   <?php require APPROOT . '/views/inc/sidebar.php'; ?>
   <div class="container">

   <!-- sidebar section  -->

      <div class="profilesidebar">
            <?php $imagepath = $this->getProfileImage($_SESSION['user_id']); ?>
            <img alt="profile picture"  src="<?php echo $imagepath; ?>" />
            <div class="edit-icon" onclick="openModal()">
               <i class="fas fa-pencil-alt"> </i>
            </div>
            <h2>
               <?php echo $_SESSION['user_name']; ?>
            </h2>
            <p>
               <?php echo $_SESSION['user_role']; ?>
            </p>
      </div>

      <!-- popup modal for uploading profile picture -->

      <div id="uploadModal" class="modal">
         <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Upload Profile Picture</h3>
            <form class="upload-form" action="<?php echo URLROOT;?>/BuyerController/uploadProfileImage" method="POST"
               enctype="multipart/form-data">
               <input type="file" name="profile_picture" accept="image/*" required>
               <button type="submit">Upload</button>
            </form>
         </div>
      </div>

      <!-- popup to confirm the save profile details -->
      <div id="popup" class="popup">
    <div class="popup-content">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <p>Your profile has been updated successfully!</p>
    </div>
  </div>


      <div class="content">
         <h1>Settings</h1>
         <div class="tabs">
            <a class="active" href="#"> General </a>
            <a href="#"> Billings </a>
         </div>
         <h2>Profile</h2>

         <form action="<?php echo URLROOT;?>/BuyerController/ManageProfile" method="post" id="profileForm">
            <div class="form-group">
               <div>
                  <label for="name"> Name </label>
                  <input id="name" name="name" placeholder="Your full name" type="text"
                     value="<?php echo $data['name']?>" />
                  <span class="invalid">
                     <?php echo $data['name_err']; ?>
                  </span>
               </div>
               <div>
                  <label for="phone"> Phone Number </label>
                  <input id="contact" name="phone" placeholder="Your number" type="text"
                     value="<?php echo $data['phone']?>" />
                  <span class="invalid">
                     <?php echo $data['phone_err']; ?>
                  </span>
               </div>
            </div>

            <hr />
            <h2>Account</h2>
            <div class="form-group">
               <div>
                  <label for="email"> Email </label>
                  <input id="email" name="email" placeholder="example.email@gmail.com" type="email"
                     value="<?php echo $data['email']?>" />
                  <span class="invalid">
                     <?php echo $data['email_err']; ?>
                  </span>
               </div>
               <div>
                  <label for="password"> Password </label>
                  <input id="password" name="password" placeholder="********" type="password" />
               </div>
            </div>
            <button class="save-btn" type="submit" onclick="showPopup()">Save information</button>
      </div>
      </form>


      <!-- bank_form.php -->
<form id="bankForm" method="POST">
    <!-- Bank Account Section -->
    <div class="tcontainer" id='tcontainer'>
        <div class="alert">
            <i class="fas fa-exclamation-circle"></i>
            Having a bank account enables you to make various payment transactions
        </div>

        <!-- Bank Account -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-university"></i>
                Bank account
            </div>

            <div class="form-group">
                <div class="form-control">
                    <label for="bank-name">Bank name</label>
                   <select id="bank-name" name="bank_name" required>
                     <option value="">Select Bank</option>
                     <option value="Bank of Ceylon">Bank of Ceylon</option>
                     <option value="People's Bank">People's Bank</option>
                     <option value="Commercial Bank of Ceylon">Commercial Bank of Ceylon</option>
                     <option value="Hatton National Bank">Hatton National Bank</option>
                     <option value="Sampath Bank">Sampath Bank</option>
                     <option value="National Savings Bank">National Savings Bank</option>
                     <option value="Seylan Bank">Seylan Bank</option>
                     <option value="Union Bank of Colombo">Union Bank of Colombo</option>
                     <option value="DFCC Bank">DFCC Bank</option>
                     <option value="NDB Bank">NDB Bank</option>
                     <option value="Pan Asia Bank">Pan Asia Bank</option>
                     <option value="Cargills Bank">Cargills Bank</option>
                     <option value="Amana Bank">Amana Bank</option>
                     <option value="HSBC Sri Lanka">HSBC Sri Lanka</option>
                     <option value="Standard Chartered Bank">Standard Chartered Bank</option>
                     <option value="Citibank Sri Lanka">Citibank Sri Lanka</option>
                  </select>

                </div>

                <div class="form-control">
                    <label for="account-number">Account number</label>
                    <input id="account-number" name="account_number" placeholder="Account number" type="text" value="<?php echo $data['account_number'];?>" required />
                </div>
                
            </div>
        </div>

        <!-- Personal Account -->
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
                    <input id="name-on-card" name="name_on_card" placeholder="Enter name on card" type="text" required />
                </div>

                <div class="form-control">
                    <label for="card-number">Card number</label>
                    <input id="card-number" name="card_number" placeholder="Enter card number" type="text" required />
                </div>

                <div class="form-control">
                    <label for="month-year">Select Month and Year:</label>
                    <input type="month" id="month-year" name="expiry_date" required />
                </div>

                <div class="form-control">
                    <label for="cvv">CVV</label>
                    <input id="cvv" name="cvv" placeholder="Enter CVV" type="text" required />
                </div>
            </div>
        </div>

        <button type="submit" class="btn">
            Save
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</form>



   </div>
   <script>
  const urlRoot = "<?php echo URLROOT; ?>";
</script>

   <script>



document.getElementById('profileForm').addEventListener('submit', function (e) {
   e.preventDefault(); // Prevent default form submission

   // Show popup
   const popup = document.getElementById('popup');
   popup.style.display = 'flex';

   // Simulate delay before actual submission
   setTimeout(() => {
      e.target.submit(); // Submit the form after 2 seconds
   }, 2000);
});

// Close Popup
function closePopup() {
   document.getElementById('popup').style.display = 'none';
}



      // Open Modal
      function openModal() {
         document.getElementById('uploadModal').style.display = 'block';
      }

      // Close Modal
      function closeModal() {
         document.getElementById('uploadModal').style.display = 'none';
      }

      // Close Modal on Outside Click
      window.onclick = function (event) {
         if (event.target == document.getElementById('uploadModal')) {
            closeModal();
         }
      }

 
  


//       document.addEventListener("DOMContentLoaded", function () {
//     const billingsTab = document.querySelector('a[href="#"]:nth-child(2)'); // Second <a> element
//     const contentDiv = document.querySelector(".content");

//     // Fetch the form content via AJAX
//     billingsTab.addEventListener("click", function (event) {
//         event.preventDefault(); // Prevent the default link behavior
//         document.getElementById('tcontainer').style.display='block'; // Add the active class to the clicked tab
//         contentDiv.style.display='none';

//         // Make an AJAX request to fetch the form HTML
//         fetch(`${urlRoot}/BuyerController/AddBankAccount`) // Replace with the correct path
//             .then(response => response.text())
//             console.log(response)
//             .then(data => {
//                 contentDiv.innerHTML = data; // Inject the form HTML into the content div
                
//                 const form = document.getElementById('bankForm'); // Get the form element by ID
//                 form.action = urlRoot + "/BuyerController/AddBankAccount"; // Set the form's action URL
//             })
//             .catch(error => {
//                 console.error("Error loading form:", error);
//             });
//     });
// });


   </script>
</body>

</html>