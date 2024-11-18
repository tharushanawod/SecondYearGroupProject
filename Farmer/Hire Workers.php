<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Workers Hiring & Rating</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/Hire Workers.css">
      
</head>
<body>
<?php require 'header.php';?>

    <section class="sub-header">
        <h2>Find the Best Farm Workers for Your Needs</h2>
        <p>Hire skilled farm workers and leave feedback to help others find the best talent.</p>
        <div class="cta-buttons">
            <a href="<?php echo URLROOT;?>/FarmerController/workerManagement"><button class="cta-btn">Hire Workers</button></a>            
        </div>        
    </section>

    <section class="how-it-works">
        <h1>How It Works</h1>
        <div class="steps">
            <div class="step">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>                
                <h4>Step 1</h4>
                <p>Browse profiles.</p>
            </div>
            <div class="step">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>                 
                <h4>Step 2</h4>
                <p>View skills and availability.</p>
            </div>
            <div class="step">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M323.4 85.2l-96.8 78.4c-16.1 13-19.2 36.4-7 53.1c12.9 17.8 38 21.3 55.3 7.8l99.3-77.2c7-5.4 17-4.2 22.5 2.8s4.2 17-2.8 22.5l-20.9 16.2L512 316.8 512 128l-.7 0-3.9-2.5L434.8 79c-15.3-9.8-33.2-15-51.4-15c-21.8 0-43 7.5-60 21.2zm22.8 124.4l-51.7 40.2C263 274.4 217.3 268 193.7 235.6c-22.2-30.5-16.6-73.1 12.7-96.8l83.2-67.3c-11.6-4.9-24.1-7.4-36.8-7.4C234 64 215.7 69.6 200 80l-72 48 0 224 28.2 0 91.4 83.4c19.6 17.9 49.9 16.5 67.8-3.1c5.5-6.1 9.2-13.2 11.1-20.6l17 15.6c19.5 17.9 49.9 16.6 67.8-2.9c4.5-4.9 7.8-10.6 9.9-16.5c19.4 13 45.8 10.3 62.1-7.5c17.9-19.5 16.6-49.9-2.9-67.8l-134.2-123zM16 128c-8.8 0-16 7.2-16 16L0 352c0 17.7 14.3 32 32 32l32 0c17.7 0 32-14.3 32-32l0-224-80 0zM48 320a16 16 0 1 1 0 32 16 16 0 1 1 0-32zM544 128l0 224c0 17.7 14.3 32 32 32l32 0c17.7 0 32-14.3 32-32l0-208c0-8.8-7.2-16-16-16l-80 0zm32 208a16 16 0 1 1 32 0 16 16 0 1 1 -32 0z"/></svg>              
                <h4>Step 3</h4>
                <p>Hire with a single click or leave feedback.</p>
            </div>
        </div>
    </section>

    <section class="featured-workers">
        <h1>Featured Workers</h1>
        <div class="worker-card">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="John Doe">
            <h4>John Doe</h4>
            <p>Skills: Harvesting, Irrigation</p>
            <button class="action-btn">Hire</button>
            <button class="action-btn">Rate & Feedback</button>
        </div>
        <div class="worker-card">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Jane Smith">
            <h4>Jane Smith</h4>
            <p>Skills: Fertilizing, Plowing</p>
            <button class="action-btn">Hire</button>
            <button class="action-btn">Rate & Feedback</button>
        </div>               
    </section>

    <section class="categories">
        <h1>Categories of Skills</h1>
        <div class="category-cards">
            <div class="category-card">
                <h4>Harvesting</h4>
                <p>Expertise in gathering crops efficiently and safely.</p>
            </div>
            <div class="category-card">
                <h4>Irrigation</h4>
                <p>Skilled in setting up and managing irrigation systems.</p>
            </div>
            <div class="category-card">
                <h4>Planting</h4>
                <p>Knowledgeable in planting techniques for various crops.</p>
            </div>
            <div class="category-card">
                <h4>Pesticide Application</h4>
                <p>Trained in safe and effective pesticide application methods.</p>
            </div>
        </div>
    </section>

    <section class="search-filter">
        <h2>Search and Filter Workers</h2>
        <input type="text" placeholder="Search by name or skill...">
        <button class="filter-btn">Filter</button>
    </section>

    <section class="feedbacks">
        <h1>Feedbacks</h1>
        <p>"I found the best workers for my farm! Highly recommend!" - Farmer Joe</p>
        <p>"Great platform to hire skilled labor. Will use again!" - Farmer Jane</p>
    </section>

    <section class="cta-bottom">
        <h3>Ready to hire top farm workers?</h3>
        <a href="<?php echo URLROOT;?>/FarmerController/workerManagement"><button class="cta-btn">Get Started</button></a>
    </section>

</body>
</html>