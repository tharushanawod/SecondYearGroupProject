<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Search Users</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/RemoveUsers.css">
    
  </head>
  <body>
    <?php require 'sidebar.php';?>


    <div class="main-content">
      <div class="search-container">
        <input type="text" placeholder="Search users..." />
        <button>Search</button>
        <?php echo APPROOT;?>
      </div>

      <table>
      <thead>
            <tr>
              <th>CUSTOMER NAME</th>
              <th>Title</th>
              <th>CONTACT NUMBER</th>
              <th>CREATED DATE</th>
              <th>EMAIL</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
        // Loop through users and display each user in a row
        if(!empty($data['users'])):
            foreach($data['users'] as $user):
        ?>
            <tr>
                <td><?php echo $user->name; ?></td>  <!-- User ID -->
                <td><?php echo $user->title; ?></td>  <!-- User Name -->
                <td><?php echo $user->phone; ?></td>  <!-- User Email -->
                <td><?php echo $user->created_at; ?></td>  <!-- User Phone -->
                <td><?php echo $user->email; ?></td>  <!-- User Title -->
                <td><button class="delete-btn" onclick="openModal(<?php echo $user->id; ?>)">Delete</button></td>

            </tr>
        <?php
            endforeach;
        else:
        ?>
            <tr>
                <td colspan="6">No users found</td>
            </tr>
        <?php endif; ?>
  </tbody>
        </table>
      </table>
    </div>
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <h2>Are you sure?</h2>
            <p>Do you really want to delete this user? This action cannot be undone.</p>
            <div class="modal-buttons">
                <button onclick="confirm()" class="confirm-btn">Yes, Delete</button>
                <button onclick="closeModal()" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>
    <script src="<?php echo URLROOT;?>/js/Admin/script.js"></script>
    <script src="<?php echo URLROOT;?>/js/Admin/nav-active.js"></script>
  </body>
</html>
