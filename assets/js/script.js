// Hide preloader after load
window.addEventListener('load', () => setTimeout(() => document.getElementById('preloader').style.display = 'none', 1000));

// Weather functionality
document.addEventListener("DOMContentLoaded", () => {
    const els = {
        searchInput: document.getElementById("citySearch"),
        searchSpinner: document.getElementById("searchSpinner"),
        currentTime: document.getElementById("currentTime"),
        forecastTable: document.getElementById('forecastTableBody'),
        hourlyForecast: document.getElementById('hourlyForecastTableBody')
    };
    
    const searchButton = els.searchInput.nextElementSibling;
    const weatherToast = new bootstrap.Toast(document.getElementById('weatherToast'));
    
    // Utility functions
    const showToast = msg => {
        document.getElementById('toastMessage').textContent = msg;
        weatherToast.show();
    };

    const toggleSearch = isLoading => {
        searchButton.classList.toggle('d-none', isLoading);
        els.searchSpinner.classList.toggle('d-none', !isLoading);
        els.searchInput.disabled = isLoading;
    };

    const updateTime = () => {
        const now = new Date();
        const hours = now.getHours();
        els.currentTime.textContent = `${hours % 12 || 12}.${now.getMinutes().toString().padStart(2, '0')} ${hours >= 12 ? 'PM' : 'AM'}`;
    };

    // Update weather data
    const updateWeather = city => {
        toggleSearch(true);
        
        fetch(`weather-api.php?city=${encodeURIComponent(city)}`)
            .then(response => response.ok ? response.json() : Promise.reject('Network error'))
            .then(data => {
                toggleSearch(false);
                
                if (data.error) {
                    throw new Error(data.message || "Location not found");
                }

                // Update main weather info
                const mainCard = document.querySelector(".main-weather-card");
                mainCard.querySelector("h2").textContent = `${data.current.temp_c}° C`;
                mainCard.querySelector("h3").textContent = data.current.condition.text;
                document.querySelector(".weather-detail p").textContent = data.location.name;
                
                // Update weather icons
                const iconUrl = `https:${data.current.condition.icon}`;
                ["small", "large"].forEach(size => {
                    const icon = document.querySelector(`.weather-icon-${size}`);
                    if (icon) icon.src = iconUrl;
                });

                // Update location details
                if (data.location) {
                    const infoItems = document.querySelectorAll(".location-info .info-item p");
                    const { region, country, lat, lon, tz_id } = data.location;
                    const astro = data.forecast?.forecastday?.[0]?.astro;
                    
                    [
                        `${region}, ${country}`,
                        `Latitude: ${lat}, Longitude: ${lon}`,
                        tz_id,
                        astro ? `Sunrise at ${astro.sunrise}&nbsp;&nbsp;Sunset at ${astro.sunset}` : ''
                    ].forEach((text, i) => infoItems[i] && (infoItems[i].innerHTML = text));
                }

                // Update date
                const now = new Date();
                document.querySelector(".weather-detail:last-child p").textContent = 
                    `${now.getDate()} - ${now.getMonth() + 1} - ${now.getFullYear()}`;

                // Update weather cards
                const details = {
                    "Wind Speed": `${data.current.wind_kph} km/h`,
                    "Temperature": `${data.current.temp_c}°C`,
                    "Humidity": `${data.current.humidity}%`,
                    "UV Index": data.current.uv,
                    "Heat Index": `${data.current.feelslike_c}°C`,
                    "Feels Like": `${data.current.feelslike_c}°C`
                };

                document.querySelectorAll(".wind-detail-card").forEach(card => {
                    const title = card.querySelector(".wind-details")?.textContent.trim();
                    if (details[title]) card.querySelector("h3").textContent = details[title];
                });

                // Clear forecast tables
                els.forecastTable.innerHTML = '';
                els.hourlyForecast.innerHTML = '';

                // Update hourly forecast
                if (data.forecast?.forecastday?.[0]?.hour) {
                    const currentHour = new Date().getHours();
                    data.forecast.forecastday[0].hour
                        .filter(hour => new Date(hour.time).getHours() > currentHour)
                        .slice(0, 4)
                        .forEach(hour => {
                            const time = new Date(hour.time).toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true
                            });
                            els.hourlyForecast.innerHTML += `
                                <tr>
                                    <td>${time}</td>
                                    <td>${hour.temp_c}°C</td>
                                    <td>${hour.chance_of_rain}%</td>
                                    <td>${hour.humidity}%</td>
                                </tr>`;
                        });
                }

                // Update daily forecast
                if (data.forecast?.forecastday) {
                    data.forecast.forecastday
                        .filter(day => new Date(day.date).toDateString() !== new Date().toDateString())
                        .slice(0, 5)
                        .forEach(day => {
                            const date = new Date(day.date).toLocaleDateString('en-US', {
                                weekday: 'short',
                                month: 'short',
                                day: 'numeric'
                            });
                            els.forecastTable.innerHTML += `
                                <tr>
                                    <td>${date}</td>
                                    <td>${day.day.maxtemp_c}°C</td>
                                    <td>${day.day.mintemp_c}°C</td>
                                    <td>${day.day.daily_chance_of_rain}%</td>
                                    <td>${day.day.avghumidity}%</td>
                                    <td>${day.day.maxwind_kph} km/h</td>
                                </tr>`;
                        });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                toggleSearch(false);
                showToast("Could not find weather data for this location. Please try another city.");
            });
    };

    // Event handlers
    const handleSearch = () => {
        const city = els.searchInput.value.trim();
        city ? updateWeather(city) : showToast("Please enter a city name");
    };

    // Event listeners
    els.searchInput.addEventListener("keypress", e => e.key === "Enter" && (e.preventDefault(), handleSearch()));
    searchButton.addEventListener("click", e => (e.preventDefault(), handleSearch()));
    els.searchInput.addEventListener("input", e => e.target.value = e.target.value.replace(/[^a-zA-Z\s-]/g, ''));

    // Initialize
    updateTime();
    setInterval(updateTime, 60000);
    updateWeather(defaultCity);
});
