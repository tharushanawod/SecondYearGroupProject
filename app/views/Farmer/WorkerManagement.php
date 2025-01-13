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
        <h1>Find Farm Workers</h1>
        
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
        </div>

        <div class="worker-grid" id="worker-grid">
            <!-- Worker cards will be inserted here by JavaScript -->
        </div>
    </div>
    </div>

<script>
   const URLROOT = "<?php echo URLROOT; ?>";
</script>
    <script>
        // Function to fetch worker data from the server
async function fetchWorkersData() {
    try {
        const response = await fetch(`${URLROOT}/FarmerController/getFarmworkers`); // Replace with the actual URL to your PHP script
        const workers = await response.json(); // Parse the JSON response
        displayWorkers(workers); // Call the function to display the workers
    } catch (error) {
        console.error('Error fetching worker data:', error);
    }
}

console.log(fetchWorkersData());

        // Function to create worker card HTML
        function createWorkerCard(worker) {
            return `
                <div class="worker-card">
                <div class="worker-photo-container">
  <img src="${worker.photo}" alt="${worker.name}" class="worker-photo">
  <div class="overlay">View Profile</div>
</div>

                   
                    <h2 class="worker-name">${worker.name}</h2>
                    <div class="location-experience">
                        <span>📍 ${worker.working_area}</span>
                        <span>💼 ${worker.experience}</span>
                    </div>
                    <div class="location-experience">
                    <span>${worker.availabilty}</span>
                    </div>
                   
                    <button class="hire-button" onclick="hireWorker(${worker.id})">Hire Now</button>
                </div>
            `;
        }

        // Function to filter workers
        function filterWorkers() {
            const searchTerm = document.getElementById('search').value.toLowerCase();
            const locationFilter = document.getElementById('location-filter').value;
            const experienceFilter = document.getElementById('experience-filter').value;

            const filteredWorkers = workers.filter(worker => {
                const matchesSearch = worker.name.toLowerCase().includes(searchTerm) ||
                    worker.skills.some(skill => skill.toLowerCase().includes(searchTerm));
                const matchesLocation = !locationFilter || worker.location === locationFilter;
                const matchesExperience = !experienceFilter || worker.experience === experienceFilter;
                
                return matchesSearch && matchesLocation && matchesExperience;
            });

            displayWorkers(filteredWorkers);
        }

        // Function to display workers
        function displayWorkers(workersToDisplay) {
            const grid = document.getElementById('worker-grid');
            grid.innerHTML = workersToDisplay.map(worker => createWorkerCard(worker)).join('');
        }

        // Function to handle hiring
        function hireWorker(workerId) {
            alert(`Initiating hiring process for worker ${workerId}`);
            // In a real app, this would open a hiring flow
        }

        // Add event listeners
        document.getElementById('search').addEventListener('input', filterWorkers);
        document.getElementById('location-filter').addEventListener('change', filterWorkers);
        document.getElementById('experience-filter').addEventListener('change', filterWorkers);

        
    </script>
</body>
</html>