<?php require APPROOT . '/views/inc/components/header.php'; ?>
    <h1>This is the view.Hi <?php 
    echo $data['id']; ?></h1>

    <h2><?php 
    
    echo $data['age'];  

    ?></h2>
    <h3><?php echo URLROOT; ?></h3>
    <h1>
        <?php 
        echo 'APP ROOT: ' . APPROOT;
        ?>
    </h1>

    <?php foreach($data['users'] as $user) : ?>
        <ul>
            <li><?php echo $user->name; ?></li>
            <li><?php echo $user->age; ?></li>
        </ul>
    <?php endforeach; ?>    

<?php require APPROOT . '/views/inc/components/footer.php'; ?>