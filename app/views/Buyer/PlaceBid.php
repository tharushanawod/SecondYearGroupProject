<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Your Bid</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/placeBid.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
       @import url(../components/sidebar.css);
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.container {
  height: 100vh;
  margin-left: 250px;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  height: 100%;
}

h1 {
  text-align: center;
  color: #034616;
  margin-bottom: 20px;
}

.product-details {
  text-align: center;
  margin-bottom: 20px;
  display: flex;
  justify-content: space-evenly;
}

.product-details img {
  width: 100%;
  max-width: 300px;
  height: auto;
  border-radius: 10px;
  object-fit: cover;
}

.product-details h2 {
  margin: 10px 0;
  font-size: 24px;
  color: #225428;
}

.product-details p {
  font-size: 16px;
  color: #333;
}

.bid-form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.bid-form input[type="number"] {
  padding: 12px;
  width: 60%;
  margin-bottom: 15px;
  border: 2px solid #ddd;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s ease;
}

.bid-form input[type="number"]:focus {
  border-color: #4caf50;
  outline: none;
  box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
}

.bid-form button {
  padding: 12px 30px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: bold;
}

.bid-form button:hover {
  background-color: #45a049;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.alert {
  position: fixed;
  top: 20px;
  right: 20px;
  background-color: #f44336;
  color: white;
  padding: 15px;
  border-radius: 5px;
  display: none;
  z-index: 1000;
}

.description{
    padding: 30px;
}
.description table {
  width: 80%;
  border-collapse: collapse;
  background-color: gray;
  margin: auto;
  
}

.description h2 {
  background-color: #e9edee;
    padding: 20px;
    text-align: center;
    
}

.description tr:nth-child(even) {
  background-color: lightgray;
}
.description tr:nth-child(odd) {
  background-color: white;
}
.description td {
  border: 1px solid gray;
  padding: 15px;
}

.details {
    background-color: #f8f9fa;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 40%;
}

.details h2 {
    color: #2c3e50;
    border-bottom: 2px solid #4caf50;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.details p {
    margin: 15px 0;
    font-size: 1.1em;
    color: #34495e;
}

.total-calculation {
    margin-top: 20px;
    padding: 15px;
    background-color: #e8f5e9;
    border-radius: 8px;
    text-align: center;
    font-size: 1.1em;
    color: #2e7d32;
    display: none;
}

    </style>
</head>
<body>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="container">
        <h1>Place Your Bid</h1>
        <div class="product-details">
            <img src="<?php echo URLROOT.'/'.$data->media;?>" alt="Product Image">
            <div class="details">
            <h2><?php echo $product->name; ?></h2>
            <p>Starting Price (1Kg): LKR <?php echo $data->starting_price; ?></p>
            <p>Current Highest Bid: <?php echo isset($data->highest_bid) ? 'LKR'.$product->highest_bid : 'No bids yet'; ?></p>
            <p>Auction Closes In: <span id="countdown"></span></p>
            <p>Quantity: <?php echo $data->quantity; ?> kg</p>

            <form class="bid-form" id="bidForm" action="<?php echo URLROOT; ?>/BuyerController/SubmitBid" method="post" onsubmit="return validateBid()">
            <input type="hidden" name="product_id" value="<?php echo $data->product_id; ?>">
            <input type="hidden" name="buyer_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="number" id="bid_amount" name="bid_amount" placeholder="Enter your bid amount" required>
            <button type="submit">Submit Bid</button>
            </form>
            <?php echo $product->seller_id; ?>
            </div>
            
        </div>
        <div id="totalCalculation" class="total-calculation"></div>
        <div class="description">
            <h2 style="color: black;">DESCRIPTION</h2>
            <table>
                <tr>
                    <td>Product ID</td>
                    <td><?php echo $data->product_id; ?></td>
                </tr>
                <tr>
                    <td>Uploaded by</td>
                    <td><?php echo $data->name; ?></td>
                </tr>
                <tr>
                    <td>District</td>
                    <td><?php echo $data->district; ?></td>
                </tr>
            </table>
        </div>
        
    </div>
    <div class="alert" id="alert"></div>
    
    <script>
        // Get closing date from PHP
        var closingDate = new Date("<?php echo $data->closing_date; ?>").getTime();

        function updateCountdown() {
            var now = new Date().getTime();
            var remainingTime = closingDate - now;

            if (remainingTime > 0) {
                var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML =
                    days + " days, " + hours + " hours, " + minutes + " minutes, " + seconds + " seconds";
            } else {
                document.getElementById("countdown").innerHTML = "Auction Closed";
                clearInterval(countdownInterval);
            }
        }

        // Update countdown every second
        var countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown(); // Run immediately

        function showAlert(message) {
            var alertDiv = document.getElementById('alert');
            alertDiv.innerHTML = message;
            alertDiv.style.display = 'block';
            setTimeout(function() {
                alertDiv.style.display = 'none';
            }, 4000);
        }

        function validateBid() {
            var bidAmount = document.getElementById('bid_amount').value;
            var startingPrice = <?php echo $data->starting_price; ?>;
            var highestBid = <?php echo isset($data->highest_bid) ? $data->highest_bid : 0; ?>;

            if (bidAmount < startingPrice || (highestBid && bidAmount <= highestBid)) {
                showAlert('Your bid must be higher than the current highest bid and the starting price.');
                return false;
            }
            return true;
        }

        document.getElementById('bidForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            if (!validateBid()) {
            return;
            }

            var formData = new FormData(this);

            fetch(this.action, {
            method: 'POST',
            body: formData
            })
            .then(response => response.json())
            .then(data => {
            if (data.success) {
                showAlert('Your bid has been submitted successfully!');

                setTimeout(function() {
                window.location.href = data.redirectUrl || "<?php echo URLROOT; ?>/BuyerController/bidProduct"; // Redirect to the desired URL
            }, 3000); // 3000 milliseconds = 3 seconds
            } else {
                alert('There was an error submitting your bid: ' + (data.error || 'Unknown error'));
            }
            })
            .catch(error => {
            alert('There was an error submitting your bid: ' + error.message);
            });
        });

        // Add this new function for real-time calculation
        document.getElementById('bid_amount').addEventListener('input', function() {
            const bidAmount = parseFloat(this.value) || 0;
            const quantity = <?php echo $data->quantity; ?>;
            const totalPayment = bidAmount * quantity;
            
            const totalCalculationDiv = document.getElementById('totalCalculation');
            
            if (bidAmount > 0) {
                totalCalculationDiv.style.display = 'block';
                totalCalculationDiv.innerHTML = `
                    <strong>Payment Summary</strong><br>
                    Bid Amount per kg: LKR ${bidAmount.toFixed(2)}<br>
                    Quantity: ${quantity} kg<br>
                    <strong>Total Payment: LKR ${totalPayment.toFixed(2)}</strong>
                `;
            } else {
                totalCalculationDiv.style.display = 'none';
            }
        });
    </script>
</body>
</html>