// Preloader
window.addEventListener('load', function() {
    setTimeout(function() {
        document.getElementById('preloader').style.display = 'none';
    }, 1000);
});

// Weather functionality
document.addEventListener("DOMContentLoaded", function () {
    // defaultCity is defined in the PHP file
    const searchInput = document.getElementById("citySearch");
    const searchButton = searchInput.nextElementSibling;
    const searchSpinner = document.getElementById("searchSpinner");
    const weatherToast = new bootstrap.Toast(document.getElementById('weatherToast'));
    
    // Function to show toast message
    function showToast(message) {
        document.getElementById('toastMessage').textContent = message;
        weatherToast.show();
    }

    // Function to toggle search loading state
    function toggleSearchLoading(isLoading) {
        searchButton.classList.toggle('d-none', isLoading);
        searchSpinner.classList.toggle('d-none', !isLoading);
        searchInput.disabled = isLoading;
    }
      // Function to update weather data
    function updateWeather(city) {
        toggleSearchLoading(true);
        
        fetch(`weather-api.php?city=${encodeURIComponent(city)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                toggleSearchLoading(false);
                
                if (data.error) {
                    showToast(data.message || "Could not find weather data for this location. Please try another city.");
                    return;
                }// Update main weather card
                document.querySelector(".main-weather-card h2").textContent = `${data.current.temp_c}° C`;
                document.querySelector(".main-weather-card h3").textContent = data.current.condition.text;
                document.querySelector(".weather-detail p").textContent = data.location.name;
                
                // Update weather icons
                const weatherIconSmall = document.querySelector(".weather-icon-small");
                const weatherIconLarge = document.querySelector(".weather-icon-large");
                if (weatherIconSmall && weatherIconLarge) {
                    const iconUrl = `https:${data.current.condition.icon}`;
                    weatherIconSmall.src = iconUrl;
                    weatherIconLarge.src = iconUrl;
                }

                // Update location details card
                const locationInfo = document.querySelector(".location-info");
                if (locationInfo) {
                    const infoItems = locationInfo.querySelectorAll(".info-item p");
                    infoItems[0].textContent = `${data.location.region}, ${data.location.country}`;
                    infoItems[1].textContent = `Latitude: ${data.location.lat}, Longitude: ${data.location.lon}`;                    infoItems[2].textContent = data.location.tz_id;
                    infoItems[3].textContent = data.location.localtime;
                }

                // Update date
                const date = new Date();
                const dateStr = `${date.getDate()} - ${date.getMonth() + 1} - ${date.getFullYear()}`;
                document.querySelector(".weather-detail:last-child p").textContent = dateStr;

                // Update other weather cards
                const details = {
                    "Wind Speed": `${data.current.wind_kph} km/h`,
                    "Temperature": `${data.current.temp_c}°C`,
                    "Humidity": `${data.current.humidity}%`,
                    "UV Index": data.current.uv,
                    "Heat Index": `${data.current.feelslike_c}°C`,
                    "Feels Like": `${data.current.feelslike_c}°C`
                };

                const cards = document.querySelectorAll(".wind-detail-card");
                cards.forEach(card => {
                    const title = card.querySelector(".wind-details")?.textContent.trim();
                    if (details[title]) {
                        card.querySelector("h3").textContent = details[title];
                    }
                });

                // Update forecast table
                const forecastTableBody = document.getElementById('forecastTableBody');
                forecastTableBody.innerHTML = ''; // Clear existing rows

                if (data.forecast && data.forecast.forecastday) {
                    data.forecast.forecastday.forEach(day => {
                        const date = new Date(day.date);
                        const formattedDate = date.toLocaleDateString('en-US', {
                            weekday: 'short',
                            month: 'short',
                            day: 'numeric'
                        });

                        const row = `
                            <tr>
                                <td>${formattedDate}</td>
                                <td>${day.day.maxtemp_c}°C</td>
                                <td>${day.day.mintemp_c}°C</td>
                                <td>${day.day.daily_chance_of_rain}%</td>
                                <td>${day.day.avghumidity}%</td>
                                <td>${day.day.maxwind_kph} km/h</td>
                            </tr>
                        `;
                        forecastTableBody.innerHTML += row;
                    });
                }
            })
            .catch(error => {
                console.error("Fetch Error:", error);
                toggleSearchLoading(false);
                showToast("Could not find weather data for this location. Please try another city.");
            });
    }

    // Update current time
    function updateCurrentTime() {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        const formattedMinutes = minutes.toString().padStart(2, '0');
        document.getElementById('currentTime').textContent = `${formattedHours}.${formattedMinutes} ${ampm}`;
    }    // Handle search input
    function handleSearch() {
        const city = searchInput.value.trim();
        if (city) {
            updateWeather(city);
        } else {
            showToast("Please enter a city name");
        }
    }

    // Search on Enter key
    searchInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            handleSearch();
        }
    });

    // Search on button click
    searchButton.addEventListener("click", function(event) {
        event.preventDefault();
        handleSearch();
    });

    // Add input event listener for real-time validation
    searchInput.addEventListener("input", function() {
        // Remove any non-letter characters except spaces and hyphens
        this.value = this.value.replace(/[^a-zA-Z\s-]/g, '');
    });

    // Update time immediately and then every minute
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000);

    // Load default city on page load
    updateWeather(defaultCity);
});
