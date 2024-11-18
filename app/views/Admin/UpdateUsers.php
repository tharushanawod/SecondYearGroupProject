<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Search Users</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/UpdateUsers.css">
  
  </head>
  <body>
   <?php require  'sidebar.php';?>

    <div class="main-content">
      <div class="search-container">
        <input type="text" placeholder="Search users..." />
        <button>Search</button>
      </div>

      <table>
        <thead>
          <tr>
            <th>CUSTOMER NAME</th>
            <th>Title</th>
            <th>CONTACT NUMBER</th>
            <th>CREATED DATE</th>
            <th>Action</th>
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
            <td>Farmer</td>
            <td>0788279990</td>
            <td>10/07/2023</td>
            <td><button class="delete-btn">Update</button></td>
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
            <td>Farm worker</td>
            <td>0788279990</td>
            <td>24/07/2023</td>
            <td><button class="delete-btn">Update</button></td>
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
            <td>Ingredient supplier</td>
            <td>0788279990</td>
            <td>08/08/2023</td>
            <td><button class="delete-btn">Update</button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <script src="<?php echo URLROOT;?>/js/Admin/nav-active.js"></script>
  </body>
</html>
