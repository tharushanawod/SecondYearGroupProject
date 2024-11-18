<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Search Users</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/AddModerators.css">
  </head>
  <body>
   <?php require 'sidebar.php';?>

    <div class="main-content">
      <div class="search-container">
        <input type="text" placeholder="Search users..." />
        <button>Search 🔎</button>
        <button>Add +</button>
      </div>

      <table>
        <thead>
          <tr>
            <th>Moderator</th>
            <th>Email</th>
            <th>CONTACT NUMBER</th>
            <th>CREATED DATE</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="user-info">
                <img
                  src="/api/placeholder/40/40"
                  alt="User"
                  class="user-avatar"
                />
                Elizabeth Lee
              </div>
            </td>
            <td>abc@gmail.com</td>
            <td>0788279990</td>
            <td>10/07/2023</td>
           
          </tr>
          <tr>
            <td>
              <div class="user-info">
                <img
                  src="/api/placeholder/40/40"
                  alt="User"
                  class="user-avatar"
                />
                Carlos Garcia
              </div>
            </td>
            <td>abc@gmail.com</td>
            <td>0788279990</td>
            <td>24/07/2023</td>
          
          </tr>
          <tr>
            <td>
              <div class="user-info">
                <img
                  src="/api/placeholder/40/40"
                  alt="User"
                  class="user-avatar"
                />
                Elizabeth Bailey
              </div>
            </td>
            <td>abc@gmail.com</td>
            <td>0788279990</td>
            <td>08/08/2023</td>
           
          </tr>
        </tbody>
      </table>
    </div>
    <script src="<?php echo URLROOT;?>/js/Admin/nav-active.js"></script>
  </body>
</html>
