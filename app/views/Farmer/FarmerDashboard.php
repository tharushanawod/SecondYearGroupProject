<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Farmer Dashboard</title>
    <link
      rel="stylesheet"
      href="<?php echo URLROOT;?>/css/Farmer/FarmerDashboard.css"
    />
    <link
      href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css"
      rel="stylesheet"
    />
   
  </head>
  <body>
  <?php require APPROOT . '/views/inc/sidebar.php'; ?>  
   
    <div class="main-content">
 


    <div class="main-content-header">
          <h1>Farmer Dashboard</h1>
        </div>

        <div class="cardBox">
          <div class="card">
            <div>
              <img
                width="50"
                height="50"
                src="https://img.icons8.com/ios/50/product--v1.png"
                alt="product--v1"
              />
            </div>
            <div>
              <div class="numbers">1,504</div>
              <div class="cardName">Products</div>
            </div>
          </div>

          <div class="card">
            <div>
              <img
                width="50"
                height="50"
                src="https://img.icons8.com/ios/50/farmer-male.png"
                alt="farmer-male"
              />
            </div>
            <div>
              <div class="numbers">80</div>
              <div class="cardName">Workers</div>
            </div>
          </div>

          <div class="card">
            <div>
              <img
                width="50"
                height="50"
                src="https://img.icons8.com/ios/50/shopping-cart--v1.png"
                alt="shopping-cart--v1"
              />
            </div>
            <div>
              <div class="numbers">284</div>
              <div class="cardName">Purchases</div>
            </div>
          </div>

          <div class="card">
            <div>
              <img
                width="50"
                height="50"
                src="https://img.icons8.com/ios/50/money--v1.png"
                alt="money--v1"
              />
            </div>
            <div>
              <div class="test">LKR 77,842</div>
              <div class="cardName">Earning</div>
            </div>
          </div>
        </div>

        <div class="details">
          <div class="recentOrders">
            <div class="cardHeader">
              <h2>Recent Orders</h2>
            </div>

            <table>
              <thead>
                <tr>
                  <td>Name</td>
                  <td>Unit Price</td>
                  <td>Quantity</td>
                  <td>Status</td>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>Dry Corn</td>
                  <td>LKR 98</td>
                  <td>100Kg</td>
                  <td><span class="status inProgress">Pending</span></td>
                </tr>

                <tr>
                  <td>Sweet Corn</td>
                  <td>LKR 108</td>
                  <td>360Kg</td>
                  <td><span class="status delivered">Paid</span></td>
                </tr>

                <tr>
                  <td>Dry Corn</td>
                  <td>LKR 78</td>
                  <td>340Kg</td>
                  <td><span class="status inProgress">Pending</span></td>
                </tr>

                <tr>
                  <td>Dry Corn</td>
                  <td>LKR 99</td>
                  <td>560Kg</td>
                  <td><span class="status delivered">Paid</span></td>
                </tr>

                <tr>
                  <td>Sweet Corn</td>
                  <td>LKR 106</td>
                  <td>310Kg</td>
                  <td><span class="status delivered">Paid</span></td>
                </tr>

                <tr>
                  <td>Dry Corn</td>
                  <td>LKR 98</td>
                  <td>450Kg</td>
                  <td><span class="status delivered">Paid</span></td>
                </tr>

                <tr>
                  <td>Sweet Corn</td>
                  <td>LKR 98</td>
                  <td>390Kg</td>
                  <td><span class="status inProgress">Pending</span></td>
                </tr>

                <tr>
                  <td>Dry Corn</td>
                  <td>LKR 98</td>
                  <td>200Kg</td>
                  <td><span class="status delivered">Paid</span></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="recentCustomers">
            <div class="cardHeader">
              <h2>Recent Hirings</h2>
            </div>

            <table>
              <tr>
                <td width="60px">
                  <div class="imgBx">
                    <img
                      src="<?php echo URLROOT;?>/images/images/img25.jpg"
                      alt="John Doe"
                    />
                  </div>
                </td>
                <td>
                  <h4>
                    Sunil <br />
                    <span> Anuradhapura</span>
                  </h4>
                </td>
              </tr>

              <tr>
                <td width="60px">
                  <div class="imgBx">
                    <img
                      src="<?php echo URLROOT;?>/images/images/img25.jpg"
                      alt="John Doe"
                    />
                  </div>
                </td>
                <td>
                  <h4>
                    Nimal<br />
                    <span> Ampara</span>
                  </h4>
                </td>
              </tr>

              <tr>
                <td width="60px">
                  <div class="imgBx">
                    <img
                      src="<?php echo URLROOT;?>/images/images/img25.jpg"
                      alt="John Doe"
                    />
                  </div>
                </td>
                <td>
                  <h4>
                    Gamage<br />
                    <span>Anuradhapura</span>
                  </h4>
                </td>
              </tr>

              <tr>
                <td width="60px">
                  <div class="imgBx">
                    <img
                      src="<?php echo URLROOT;?>/images/images/img25.jpg"
                      alt="John Doe"
                    />
                  </div>
                </td>
                <td>
                  <h4>
                    Siriwardhana<br />
                    <span>Anuradhapura</span>
                  </h4>
                </td>
              </tr>

              <tr>
                <td width="60px">
                  <div class="imgBx">
                    <img
                      src="<?php echo URLROOT;?>/images/images/img25.jpg"
                      alt="John Doe"
                    />
                  </div>
                </td>
                <td>
                  <h4>
                    Dissanyaka <br />
                    <span>Puttlam</span>
                  </h4>
                </td>
              </tr>

              <tr>
                <td width="60px">
                  <div class="imgBx">
                    <img
                      src="<?php echo URLROOT;?>/images/images/img25.jpg"
                      alt="John Doe"
                    />
                  </div>
                </td>
                <td>
                  <h4>
                    Ranathunga <br />
                    <span>Kurunegala</span>
                  </h4>
                </td>
              </tr>

              <tr>
                <td width="60px">
                  <div class="imgBx">
                    <img
                      src="<?php echo URLROOT;?>/images/images/img25.jpg"
                      alt="John Doe"
                    />
                  </div>
                </td>
                <td>
                  <h4>
                    Somapala <br />
                    <span>Ampara</span>
                  </h4>
                </td>
              </tr>

              <tr>
                <td width="60px">
                  <div class="imgBx">
                    <img
                      src="<?php echo URLROOT;?>/images/images/img25.jpg"
                      alt="John Doe"
                    />
                  </div>
                </td>
                <td>
                  <h4>
                    Sarath<br />
                    <span>Anuradhapura</span>
                  </h4>
                </td>
              </tr>
            </table>
          </div>
        </div>
    </div>


<script>
// Get all the links
const elements = document.querySelectorAll('.test');

// When the page loads, check if any link should be "active"
window.addEventListener('load', () => {
  // Get the active link from localStorage
  const activeLinkId = localStorage.getItem('activeLink');

  if (activeLinkId) {
    // If there's an active link, add the "active" class to it
    const activeElement = document.getElementById(activeLinkId);
    if (activeElement) {
      activeElement.classList.add('active');
    }
  }
});

// When a link is clicked, mark it as active
elements.forEach(element => {
  element.addEventListener('click', (event) => {
    event.preventDefault();  // Prevent the default link behavior

    // Remove the "active" class from all elements
    elements.forEach(el => el.classList.remove('active'));

    // Add the "active" class to the clicked element
    element.classList.add('active');

    // Store the clicked link's ID in localStorage
    localStorage.setItem('activeLink', element.id);

    // Optionally navigate after class is added
    window.location.href = element.href;
  });
});
</script>

  </body>
</html>
