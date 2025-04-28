<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Worker Profiles</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/WorkerManagement.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
    <div class="main-container">
        <?php require APPROOT . '/views/inc/sidebar.php'; ?>
        <div class="container">
            <h1><i class="fas fa-users"></i> Find Farm Workers</h1>
            
            <div class="filters">
                <div class="input-group">
                    <input type="text" id="search" placeholder="Search by name or skills...">
                </div>
                <div class="input-group">
                    <select id="location-filter">
                        <option value="">All locations</option>
                        <option value="California">California</option>
                        <option value="Oregon">Oregon</option>
                        <option value="Texas">Texas</option>
                    </select>
                </div>
                <div class="input-group">
                    <select id="experience-filter">
                        <option value="">All experience</option>
                        <option value="3+ years">3+ years</option>
                        <option value="5+ years">5+ years</option>
                        <option value="7+ years">7+ years</option>
                    </select>
                </div>
                <div class="input-group">
                    <a href="<?php echo URLROOT . '/FarmerController/ViewPendingJobRequests'; ?>">
                        <button class="pending-requests-button"><i class="fas fa-clock"></i> Pending Requests</button>
                    </a>
                </div>
            </div>
            
            <div class="worker-grid" id="worker-grid">
                <?php foreach ($data as $worker): ?>
                <div class="worker-card">
                    <a href="<?php echo URLROOT . '/FarmerController/WorkerProfile/' . $worker->user_id; ?>">
                        <div class="worker-photo-container">
                            <img src="<?php 
                                // Check if file_path is empty or NULL, and provide the appropriate image
                                echo empty($worker->file_path) ? URLROOT . '/images/profile.jpg' : URLROOT . '/' . htmlspecialchars($worker->file_path);
                            ?>" 
                            alt="<?php echo htmlspecialchars($worker->name); ?>" 
                            class="worker-photo">
                            <div class="overlay"><i class="fas fa-eye"></i> View Profile</div>
                        </div>
                    </a>     
                    
                    <h2 class="worker-name"><?php echo htmlspecialchars($worker->name); ?></h2>
                    <div class="location-experience">
                        <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($worker->working_area); ?></span>
                    </div>
                    <div class="rate">
                        <span><i class="fas fa-money-bill-wave"></i> LKR <?php echo htmlspecialchars($worker->hourly_rate); ?>/day</span>
                    </div>
                    <div class="skills-list">
                        <?php
                        // Assuming `skills` is a comma-separated string, split and format it.
                        $skills = explode(',', $worker->skills);
                        foreach ($skills as $skill) {
                            echo '<span class="skill-tag">' . htmlspecialchars(trim($skill)) . '</span>';
                        }
                        ?>
                    </div>
                    <div class="location-experience">
                        <span class="availability <?php echo strtolower($worker->availability) === 'available' ? 'available' : 'unavailable'; ?>">
                            <i class="fas <?php echo strtolower($worker->availability) === 'available' ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                            <?php echo htmlspecialchars($worker->availability); ?>
                        </span>
                    </div>
                    <?php if (strtolower($worker->availability) === "available"): ?>
                        <a href="<?php echo URLROOT.'/FarmerController/HireWorker/'.$worker->user_id; ?>">
                            <button class="hire-button"><i class="fas fa-handshake"></i> Hire Now</button>
                        </a>
                    <?php else: ?>
                        <span class="hire-button unavailable-btn"><i class="fas fa-ban"></i> Currently Hired</span>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('search').addEventListener('input', filterWorkers);
        document.getElementById('location-filter').addEventListener('change', filterWorkers);
        document.getElementById('experience-filter').addEventListener('change', filterWorkers);

        function filterWorkers() {
            const searchTerm = document.getElementById('search').value.toLowerCase();
            const locationFilter = document.getElementById('location-filter').value.toLowerCase();
            const experienceFilter = document.getElementById('experience-filter').value.toLowerCase();
            
            const workerCards = document.querySelectorAll('.worker-card');
            
            workerCards.forEach(card => {
                const name = card.querySelector('.worker-name').textContent.toLowerCase();
                const skills = Array.from(card.querySelectorAll('.skill-tag')).map(tag => tag.textContent.toLowerCase());
                const location = card.querySelector('.location-experience span').textContent.toLowerCase();
                
                // Simple filtering logic - can be expanded as needed
                const matchesSearch = searchTerm === '' || 
                                     name.includes(searchTerm) || 
                                     skills.some(skill => skill.includes(searchTerm));
                const matchesLocation = locationFilter === '' || location.includes(locationFilter);
                
                if (matchesSearch && matchesLocation) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>