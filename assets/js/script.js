// Preloader
window.addEventListener('load', function() {
    setTimeout(function() {
        document.getElementById('preloader').style.display = 'none';
    }, 1000);
});

// Weather functionality
document.addEventListener("DOMContentLoaded", function () {
    const defaultCity = "Colombo";
    const searchInput = document.getElementById("citySearch");
    
    // Function to update weather data
    function updateWeather(city) {
        fetch(`weather-api.php?city=${encodeURIComponent(city)}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Weather API Error:", data.error.message);
                    return;
                }                // Update main weather card
                document.querySelector(".main-weather-card h2").textContent = `${data.current.temp_c}° C`;
                document.querySelector(".main-weather-card h3").textContent = data.current.condition.text;
                document.querySelector(".weather-detail p").textContent = data.location.name;

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
            })
            .catch(error => console.error("Fetch Error:", error));
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
    }

    // Handle search input
    searchInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            const city = this.value.trim();
            if (city) {
                updateWeather(city);
            }
        }
    });

    // Update time immediately and then every minute
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000);

    // Load default city on page load
    updateWeather(defaultCity);
});
