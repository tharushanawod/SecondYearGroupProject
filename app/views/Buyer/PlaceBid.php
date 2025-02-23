<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Your Bid</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/placeBid.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
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
            <p>Current Highest Bid: <?php echo isset($data->highest_bid) ? 'LKR'.$data->highest_bid : 'No bids yet'; ?></p>
            <p>Auction Closes In: <span id="countdown"></span></p>
            <p>Quantity: <?php echo $data->quantity; ?> kg</p>

            <form class="bid-form" id="bidForm" action="<?php echo URLROOT; ?>/BuyerController/SubmitBid"  onsubmit="return validateBid()">
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
    // Assign PHP variables to JavaScript variables in the HTML
    var closingDate = new Date("<?php echo $data->closing_date; ?>").getTime();
    var startingPrice = <?php echo $data->starting_price; ?>;
    var highestBid = <?php echo isset($data->highest_bid) ? $data->highest_bid : 0; ?>;
    var quantity = <?php echo $data->quantity; ?>;
    const URLROOT = "<?php echo URLROOT; ?>";
</script>
<script src="<?php echo URLROOT;?>/js/Buyer/PlaceBid.js"></script>
</body>
</html>