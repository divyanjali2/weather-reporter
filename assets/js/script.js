// Preloader
window.addEventListener('load', function() {
    setTimeout(function() {
        document.getElementById('preloader').style.display = 'none';
    }, 1000);
});

// Weather functionality
document.addEventListener("DOMContentLoaded", function () {
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
                const hourlyForecastTableBody = document.getElementById('hourlyForecastTableBody');
                forecastTableBody.innerHTML = ''; 
                hourlyForecastTableBody.innerHTML = ''; 

                console.log('Received weather data:', data); // Debug log

                // Update hourly forecast for today
                if (data.forecast && data.forecast.forecastday && data.forecast.forecastday[0]) {
                    console.log('Processing hourly forecast...'); // Debug log
                    const now = new Date();
                    const currentHour = now.getHours();
                    const hours = data.forecast.forecastday[0].hour;
                    
                    console.log('Current hour:', currentHour); // Debug log
                    console.log('Available hours:', hours); // Debug log
                    
                    // Get next 3 hours from current hour
                    const nextHours = hours
                        .filter(hour => {
                            const hourTime = new Date(hour.time);
                            return hourTime.getHours() > currentHour;
                        })
                        .slice(0, 4);

                    console.log('Next hours to display:', nextHours); // Debug log

                    nextHours.forEach(hour => {
                        const hourTime = new Date(hour.time);
                        const formattedTime = hourTime.toLocaleTimeString('en-US', {
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true
                        });

                        const row = `
                            <tr>
                                <td>${formattedTime}</td>
                                <td>${hour.temp_c}°C</td>
                                <td>${hour.chance_of_rain}%</td>
                                <td>${hour.humidity}%</td>
                            </tr>
                        `;
                        hourlyForecastTableBody.innerHTML += row;
                    });
                } else {
                    console.log('No hourly forecast data available'); // Debug log
                }

                // Update daily forecast table
                if (data.forecast && data.forecast.forecastday) {
                    console.log('Processing daily forecast...'); // Debug log
                    const today = new Date().toDateString();
                    // Filter out today's date and get next 5 days
                    const futureDays = data.forecast.forecastday
                        .filter(day => new Date(day.date).toDateString() !== today)
                        .slice(0, 5);  // Get only the next 5 days

                    console.log('Future days to display:', futureDays); // Debug log

                    futureDays.forEach(day => {
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
                } else {
                    console.log('No daily forecast data available'); // Debug log
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

    searchInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^a-zA-Z\s-]/g, '');
    });

    // Update time immediately and then every minute
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000);

    updateWeather(defaultCity);
});
