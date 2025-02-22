<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Cart/Checkout.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <title>Checkout</title>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <h1>Checkout</h1>

    <div class="container">
       <div class="container-inside ">
        <form class="billing-details">
            <h2>Payment details</h2>
            <label for="first-name">First name *</label>
            <input type="text" id="first-name" required>

            <label for="last-name">Last name *</label>
            <input type="text" id="last-name" required>

            <label for="company">Company name (optional)</label>
            <input type="text" id="company">

            <label for="district">District *</label>
<select id="district" name="district" required>
    <option value="" disabled selected>Select your district</option>
    <option value="Ampara">Ampara</option>
    <option value="Anuradhapura">Anuradhapura</option>
    <option value="Badulla">Badulla</option>
    <option value="Batticaloa">Batticaloa</option>
    <option value="Colombo">Colombo</option>
    <option value="Galle">Galle</option>
    <option value="Gampaha">Gampaha</option>
    <option value="Hambantota">Hambantota</option>
    <option value="Jaffna">Jaffna</option>
    <option value="Kalutara">Kalutara</option>
    <option value="Kandy">Kandy</option>
    <option value="Kegalle">Kegalle</option>
    <option value="Kilinochchi">Kilinochchi</option>
    <option value="Kurunegala">Kurunegala</option>
    <option value="Mannar">Mannar</option>
    <option value="Matale">Matale</option>
    <option value="Matara">Matara</option>
    <option value="Monaragala">Monaragala</option>
    <option value="Mullaitivu">Mullaitivu</option>
    <option value="Nuwara Eliya">Nuwara Eliya</option>
    <option value="Polonnaruwa">Polonnaruwa</option>
    <option value="Puttalam">Puttalam</option>
    <option value="Ratnapura">Ratnapura</option>
    <option value="Trincomalee">Trincomalee</option>
    <option value="Vavuniya">Vavuniya</option>
</select>


            <label for="address">Street address *</label>
            <input type="text" id="address" required>
            <input type="text" id="address-optional" placeholder="Apartment, suite, unit, etc. (optional)">

            <label for="city">Town / City *</label>
            <input type="text" id="city" required>

            <label for="postcode">Postcode / ZIP *</label>
            <input type="text" id="postcode" required>

            <label for="phone">Phone *</label>
            <input type="tel" id="phone" required>

            <label for="email">Email address *</label>
            <input type="email" id="email" required>

            <h2>Additional information</h2>
            <label for="order-notes">Order notes (optional)</label>
            <textarea id="order-notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
        </form>
        </div>
        <div class="order-summary">
            <h2>Your order</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['cart_items'])): ?>
                        <?php foreach ($data['cart_items'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item->product_name) . ' × ' . $item->quantity; ?></td>
                                <td>LKR <?php echo number_format($item->price * $item->quantity, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Subtotal</td>
                            <td>LKR <?php echo number_format($data['subTotal'], 2); ?></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>LKR <?php echo number_format($data['subTotal'], 2); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Your cart is empty</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="payment-method">
                <label>
                    <input type="radio" name="payment" value="check"> Card Payments
                </label>                 
               
            </div>

            <a href="<?php echo URLROOT;?>/CartController/pay"><button class="place-order">PLACE ORDER</button></a>
        </div> 
    </div>   
</body>
</html>