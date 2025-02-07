<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Your Bid</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/placeBid.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
       
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
    </script>
</body>
</html>