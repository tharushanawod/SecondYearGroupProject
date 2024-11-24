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
 
      <form method="POST" action="<?php echo URLROOT; ?>/AdminController/test" class="search-container">
        <input type="text" name="search" placeholder="Search users..."  />
        <button type="submit">Search</button>
        <a href="<?php echo URLROOT;?>/AdminController/RemoveUsers"><button>Refresh</button></a>

       
    </form>
  
      <table>
      <thead>
            <tr>
              <th>CUSTOMER ID</th>
              <th>Name</th>
              <th>CONTACT NUMBER</th>
              <th>CREATED DATE</th>
              <th>EMAIL</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
// Loop through users and display each user in a row
if (!empty($data['users'])):
    foreach ($data['users'] as $user):
?>
    <tr>
        <td><?php echo htmlspecialchars($user->id); ?></td>  <!-- User ID -->
        <td><?php echo htmlspecialchars($user->name); ?></td>  <!-- User Name -->
        <td><?php echo htmlspecialchars($user->phone); ?></td>  <!-- User Phone -->
        <td><?php echo htmlspecialchars($user->created_at); ?></td>  <!-- Created At -->
        <td><?php echo htmlspecialchars($user->email); ?></td>  <!-- User Email -->
        <td>
<a href="<?php echo URLROOT; ?>/AdminController/verifyUser/<?php echo $user->id; ?>"> <button type="submit" class="delete-btn">Verify</button></a>
<a href="<?php echo URLROOT; ?>/AdminController/verifyUser/<?php echo $user->id; ?>"> <button type="submit" class="delete-btn">View Document</button></a>
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this user?');
    }
</script>
        </td>
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
    <!-- <script src="<?php echo URLROOT;?>/js/Admin/nav-active.js"></script> -->

  </body>
</html>
