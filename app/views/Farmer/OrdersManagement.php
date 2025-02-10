<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/OrdersManagement.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
        @import url(../components/sidebar.css);
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;

}

body {
  margin: 0;
  padding: 0;
  background-color: #f4f4f4;

}

.container {
  margin-left: 300px;
  gap: 20px; /* Space between image and form */
  height: 100vh;
  padding: 40px;
}

h1 {
  text-align: center;
  font-size: 40px;
}

.filter-options {
  margin-bottom: 20px;
}

label {
  margin-right: 10px;
}

select {
  padding: 10px;
  border-radius: 4px;
  border: 1px solid #ddd;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  margin-bottom: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
}

th,
td {
  padding: 16px 20px;
  text-align: left;
  border-bottom: 1px solid #e0e0e0;
}

th {
  background-color: #f5f5f5;
  color: #333;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 14px;
  letter-spacing: 0.5px;
  border-bottom: 2px solid #e0e0e0;
}

tr {
  background-color: white;
}

tr:nth-child(even) {
  background-color: #f8f9fa;
}

table tbody tr {
  transition: all 0.2s ease;
}

tr:hover {
  background-color: #f1f9f6;
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.actions button {
  padding: 5px 10px;
  margin-right: 5px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 150px;
}

.actions button.accept {
  background-color: #28a745;
  color: white;
}

.actions button.send-code {
  background-color: #007bff;
  color: white;
}

.actions button:hover {
  opacity: 0.8;
}

.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
  padding-top: 60px;
}

.modal-content {
  background-color: #fff;
  margin: 5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 500px;
  border-radius: 8px;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
}

.modal-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.modal-actions button {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#acceptOrderBtn {
  background-color: #28a745;
  color: white;
}

#acceptOrderBtn:hover {
  background-color: #218838;
}

#sendCodeBtn {
  background-color: #007bff;
  color: white;
}

#sendCodeBtn:hover {
  background-color: #0056b3;
}

#closeBtn {
  background-color: #6c757d;
  color: white;
}

#closeBtn:hover {
  background-color: #5a6268;
}

.main-container {
  background-color: white;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.filter-options {
  margin-bottom: 30px;
  padding: 15px 0;
}

.filter-options select {
  padding: 10px 15px;
  border-radius: 6px;
  border: 1px solid #ddd;
  background-color: white;
  font-size: 14px;
  min-width: 200px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.filter-options select:hover {
  border-color: #2c3e50;
}

.filter-options select:focus {
  outline: none;
  border-color: #2c3e50;
  box-shadow: 0 0 0 2px rgba(44, 62, 80, 0.1);
}

    </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="container">
        <h1>Orders From Buyers</h1>

        <div class="main-container">
            <div class="filter-options">
                <label for="statusFilter">Filter by Status:</label>
                <select id="statusFilter">
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="accepted">Accepted</option>
                </select>
            </div>

            <table id="ordersTable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Buyer</th>
                        <th> Unit Price(Rs)</th>
                        <th>Quantity (kg)</th>
                        <th>Status</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dry Corn</td>
                        <td>Dasanayaka</td>
                        <td>100</td>
                        <td>200 kg</td>
                        <td>Pending</td>
                      
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sweet Corn</td>
                        <td>N.M Herath</td>
                        <td>120</td>
                        <td>50 kg</td>
                        <td>Accepted</td>
                       
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Dry Cornd</td>
                        <td>H.K Gajasinghe</td>
                        <td>89</td>
                        <td>250 kg</td>
                        <td>Accepted</td>
                      
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Sweet Corn</td>
                        <td>N.B Asanka</td>
                        <td>99</td>
                        <td>300 kg</td>
                        <td>Pending</td>
                       
                    </tr>
                    <!-- Add remaining orders similarly -->
                </tbody>
            </table>

         
        </div>
    </div>
</body>
</html>
