<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/purchase history.css">
    <style>
        /* Modal and Overlay Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #f0fdf4; /* Light green background */
            border: 2px solid #10b981; /* Emerald green border */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 20px;
            width: 300px;
            text-align: center;
            color: #065f46; /* Dark green text */
        }

        .modal h3 {
            margin-bottom: 10px;
            color: #065f46;
        }

        .modal p {
            margin-bottom: 10px;
            font-size: 14px;
            color: #065f46;
        }

        .modal button {
            padding: 8px 16px;
            margin-top: 10px;
            font-size: 14px;
            color: #ffffff;
            background: #10b981; /* Emerald green button */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .modal button:hover {
            background: #047857; /* Darker emerald green on hover */
        }
        .contact-btn{
            border: none;
            padding: 5px 10px;
            background-color: #3ab583;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="container">      
    <h2 class="header-content">Purchase History</h2>        
    <table id="purchaseHistory">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Farmer</th>
                <th>Purchase Date</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Status</th>
                <th>Contact</th> <!-- New Column -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Sample data with farmer details
            $data = 
                [
                    ['product' => 'Dry Corn', 'farmer' => 'Sunil', 'date' => '2024-04-25', 'quantity' => '100 kg', 'price' => 'LKR 123', 'status' => 'Paid', 'details' => 'Address: Village A, Contact: 0712345678'],
                    ['product' => 'Sweet Corn', 'farmer' => 'Kamal', 'date' => '2024-05-11', 'quantity' => '568 kg', 'price' => 'LKR 99', 'status' => 'Paid', 'details' => 'Address: Village B, Contact: 0718765432'],
                    ['product' => 'Dry Corn', 'farmer' => 'Silva', 'date' => '2024-07-20', 'quantity' => '555 kg', 'price' => 'LKR 98', 'status' => 'Paid', 'details' => 'Address: Village C, Contact: 0771234567'],
                    ['product' => 'Sweet Corn', 'farmer' => 'Nimal', 'date' => '2024-08-15', 'quantity' => '420 kg', 'price' => 'LKR 105', 'status' => 'Paid', 'details' => 'Address: Village D, Contact: 0719876543'],
                    ['product' => 'Dry Corn', 'farmer' => 'Ranjith', 'date' => '2024-09-10', 'quantity' => '230 kg', 'price' => 'LKR 112', 'status' => 'Paid', 'details' => 'Address: Village E, Contact: 0777654321'],
                    ['product' => 'Sweet Corn', 'farmer' => 'Bandara', 'date' => '2024-10-05', 'quantity' => '315 kg', 'price' => 'LKR 102', 'status' => 'Paid', 'details' => 'Address: Village F, Contact: 0701234567'],
                    ['product' => 'Dry Corn', 'farmer' => 'Mendis', 'date' => '2024-11-22', 'quantity' => '600 kg', 'price' => 'LKR 99', 'status' => 'Paid', 'details' => 'Address: Village G, Contact: 0714567890'],
                    ['product' => 'Sweet Corn', 'farmer' => 'Chathura', 'date' => '2024-12-01', 'quantity' => '500 kg', 'price' => 'LKR 107', 'status' => 'Paid', 'details' => 'Address: Village H, Contact: 0765432109']
               
                
                // Add similar entries as needed...
            ];

            foreach ($data as $row) {
                echo "<tr>
                        <td>{$row['product']}</td>
                        <td>{$row['farmer']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['status']}</td>
                        <td><button class='contact-btn' onclick=\"openContactModal('{$row['farmer']}', '{$row['details']}')\">Contact</button></td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal for Contact Details -->
<div class="modal-overlay" id="modal-overlay"></div>
<div class="modal" id="contact-modal">
    <h3 id="farmer-name"></h3>
    <p id="farmer-details"></p>
    <button onclick="closeContactModal()">Close</button>
</div>

<script>
    function openContactModal(farmerName, farmerDetails) {
        document.getElementById("farmer-name").innerText = farmerName;
        document.getElementById("farmer-details").innerText = farmerDetails;
        document.getElementById("modal-overlay").style.display = "block";
        document.getElementById("contact-modal").style.display = "block";
    }

    function closeContactModal() {
        document.getElementById("modal-overlay").style.display = "none";
        document.getElementById("contact-modal").style.display = "none";
    }
</script>

</body>
</html>
