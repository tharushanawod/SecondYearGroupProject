  
        // Initialize start date picker
        const startDatePicker = flatpickr("#start_date", {
            minDate: "today",
            disable: bookedDates,
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr) {
                // Update end date picker's min date when start date is selected
                if (endDatePicker) {
                    endDatePicker.set('minDate', dateStr);
                }
            }
        });

        // Initialize end date picker
        const endDatePicker = flatpickr("#end_date", {
            minDate: "today",
            disable: bookedDates,
            dateFormat: "Y-m-d"
        });

        // Form submission handling
        document.getElementById('hireWorkerForm').addEventListener('submit', function(event) {
            // Show confirmation popup
            event.preventDefault();
            var popupMessage = document.getElementById('popupMessage');
            popupMessage.style.display = 'block';
            setTimeout(function() {
                popupMessage.style.display = 'none';
                event.target.submit();
            }, 3000);
        });