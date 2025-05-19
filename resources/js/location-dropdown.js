document.addEventListener('DOMContentLoaded', () => {
    // Get the dropdown elements
    const provinceSelect = document.getElementById('province_id');
    const citySelect = document.getElementById('city_id');
    const areaSelect = document.getElementById('area_id');
    
    // If province dropdown exists
    if (provinceSelect) {
        // When province selection changes
        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            
            // Clear city and area dropdowns
            if (citySelect) {
                citySelect.innerHTML = '<option value="">Select City</option>';
                
                if (areaSelect) {
                    areaSelect.innerHTML = '<option value="">Select Area (Optional)</option>';
                }
                
                if (provinceId) {
                    // Fetch cities for the selected province
                    fetch(`/cities/${provinceId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(cities => {
                            for (const city of cities) {
                                const option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            }
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                }
            }
        });
    }
    
    // If city dropdown exists
    if (citySelect) {
        // When city selection changes
        citySelect.addEventListener('change', function() {
            const cityId = this.value;
            
            // Clear area dropdown
            if (areaSelect) {
                areaSelect.innerHTML = '<option value="">Select Area (Optional)</option>';
                
                if (cityId) {
                    // Fetch areas for the selected city
                    fetch(`/areas/${cityId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(areas => {
                            for (const area of areas) {
                                const option = document.createElement('option');
                                option.value = area.id;
                                option.textContent = area.name;
                                areaSelect.appendChild(option);
                            }
                        })
                        .catch(error => console.error('Error fetching areas:', error));
                }
            }
        });
    }
});


