document.getElementById("applyFilters").addEventListener("click", () => {
    const sortBy = document.getElementById("sortBy").value;
    const minPrice = document.getElementById("minPrice").value;
    const maxPrice = document.getElementById("maxPrice").value;
    const minQty = document.getElementById("minQuantity").value;
    const maxQty = document.getElementById("maxQuantity").value;
  
    const url = `${URLROOT}/ManufacturerController/filterBids`;
  
    fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ sortBy, minPrice, maxPrice, minQty, maxQty }),
    })
      .then((res) => res.json())
      .then((data) => {
        const container = document.getElementById("activeBids");
        container.innerHTML = "";
  
        if (data.length === 0) {
          container.innerHTML = "<p>No matching bids found.</p>";
          return;
        }
  
        data.forEach((product) => {
          const currentTime = new Date();
          const closingTime = new Date(product.closing_date);
          const diffMs = closingTime - currentTime;
  
          const days = Math.floor(diffMs / (1000 * 60 * 60 * 24));
          const hours = Math.floor((diffMs / (1000 * 60 * 60)) % 24);
          const timeClass = days < 2 ? "time-remaining urgent" : "time-remaining";
          const remainingTime = `${days} days, ${hours} hours`;
  
          const rating = Math.round(parseFloat(product.avg_rating || 0));
          let stars = "";
          for (let i = 1; i <= 5; i++) {
            stars += i <= rating
              ? '<i class="fa-solid fa-star"></i>'
              : '<i class="fa-regular fa-star"></i>';
          }
  
          const card = `
            <div class="bid-card">
              <img src="${URLROOT}/${product.media}" alt="Product Image">
              <div class="bid-status">Active</div>
              <div class="card-content">
                <h3>Corn</h3>
  
                <div class="${timeClass}">
                  <i class="fa-solid fa-clock"></i>
                  <span>${remainingTime} remaining</span>
                </div>
  
                <div class="bid-info">
                  <div class="info-row"><span class="info-label">Starting Price:</span> <span class="info-value">LKR ${product.starting_price}/kg</span></div>
                  <div class="info-row"><span class="info-label">Current Highest:</span> <span class="info-value highlight">${product.highest_bid ? 'LKR ' + product.highest_bid : 'No bids yet'}</span></div>
                  <div class="info-row"><span class="info-label">Quantity:</span> <span class="info-value">${product.quantity} kg</span></div>
                </div>
  
                <div class="farmer-info">
                  <a href="${URLROOT}/ManufacturerController/FarmerProfile/${product.user_id}" class="farmer-link">
                    <i class="fa-solid fa-user"></i> Farmer Profile
                  </a>
                  <div class="rating">${stars} (${product.avg_rating || 0})</div>
                </div>
  
                <a href="${URLROOT}/ManufacturerController/PlaceBid/${product.product_id}" class="action-btn">
                  <i class="fa-solid fa-gavel"></i> Place Bid
                </a>
              </div>
            </div>
          `;
  
          container.innerHTML += card;
        });
      });
  });
  