<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Checkout.css">
    <title>Checkout</title>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <h1>Checkout</h1>

    <div class="container">
       <div class="container-inside ">
        <form class="billing-details">
            <h2>Billing details</h2>
            <label for="first-name">First name *</label>
            <input type="text" id="first-name" required>

            <label for="last-name">Last name *</label>
            <input type="text" id="last-name" required>

            <label for="company">Company name (optional)</label>
            <input type="text" id="company">

            <label for="country">Country / Region *</label>
            <select id="country" required>
                <option value="Sri Lanka">Sri Lanka</option>
                <!-- Add more countries as needed -->
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
                    <tr>
                        <td>Nitrogen Rich Fertilizer × 1</td>
                        <td>LKR 1500.00</td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td>LKR 1500.00</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>LKR 1500.00</td>
                    </tr>
                </tbody>
            </table>

            <div class="payment-method">
                <label>
                    <input type="radio" name="payment" value="check"> Card Payments
                </label>                 
                <label>
                    <input type="radio" name="payment" value="cash"> Cash on Delivery
                </label>
            </div>

            <a href="<?php echo URLROOT;?>/SupplierController/checkoutConfirmation"><button class="place-order">PLACE ORDER</button></a>
        </div> 
    </div>   
</body>
</html>