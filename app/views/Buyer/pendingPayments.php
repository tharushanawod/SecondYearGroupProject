<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Need support?</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/pendingPayments.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
<div class="payments">
   
    <h2 class="payments-header">Payments</h2>            
    
    <table>
        <thead>
            <tr>
                <td>Bid Id</td>
                <td>Bid Amount</td>
                <td>Quantity</td>
                <td>Pay Amount</td>
                <td>Action</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>LKR 1200</td>
                <td>100kg</td>
                <td>LKR 70,000</td>
                <td><button class="paynow">Pay Now</button><button class="status">Status</button></td>
            </tr>

            <tr>
                <td>2</td>
                <td>LKR 1500</td>
                <td>150kg</td>
                <td>LKR 80,000</td>
                <td><button class="paynow">Pay Now</button><button class="status">Status</button></td>
            </tr>

            <tr>
                <td>3</td>
                <td>LKR 1000</td>
                <td>80kg</td>
                <td>LKR 60,000</td>
                <td><button class="paynow">Pay Now</button><button class="status">Status</button></td>
            </tr>               
        </tbody>
    </table>
</div>
</body>
</html>