# Weather Reporter Website

A modern, responsive weather reporting website that provides real-time weather information, hourly forecasts, and weather forecasts for 5 days using the WeatherAPI.com service.

## Features

- Real-time weather data
- Current weather conditions with detailed metrics
- Hourly forecast for the next 4 hours
- 5-day weather forecast
- Location-based weather information
- Responsive design for all devices
- Eye-catching UI with gradient cards and subtle blur effects.
- Loading animations and toast notifications

## Prerequisites

- PHP 7.4 or higher
- XAMPP/WAMP/MAMP or any PHP server
- Node.js and npm
- WeatherAPI.com API key

## Installation

1. Clone the repository to your local server directory:
   ```bash
   git clone https://github.com/divyanjali2/weather-reporter.git
   cd weather-reporter-website
   ```

2. Install Node.js dependencies and composer
   ```bash
   npm install
   composer require vlucas/phpdotenv
   ```

3. Make a copy from .env.example and rename the file as .env

4. Replace `'your_api_key_here_generated_from_weatherapi.com'` with your WeatherAPI.com API key in the .env file

## Working with SCSS

The project uses SCSS for styling. The SCSS files are located in the `assets/scss` directory.

### SCSS File Structure

```
assets/scss/
├── _variables.scss    # Global variables
├── _overrides.scss   # Bootstrap overrides
├── _responsive.scss  # Media queries
├── _style.scss      # Main styles
└── main.scss        # Entry point
```

### Compiling SCSS

1. Install SASS globally if you haven't already:
   ```bash
   npm install -g sass
   ```

2. To compile SCSS once:
   ```bash
   sass assets/scss/main.scss assets/css/main.css
   ```

3. To watch for changes and compile automatically:
   ```bash
   sass --watch assets/scss:assets/css --style expanded
   ```

## Project Structure

```
weather-reporter-website/
├── assets/
│   ├── css/         # Compiled CSS files
│   ├── js/          # JavaScript files
│   ├── images/      # Image assets
│   └── scss/        # SCSS source files
├── parts/          # Reusable PHP components
├── vendor/         # Composer dependencies
├── index.php       # Main entry point
├── weather-api.php # Weather API handler
├── config.php      # Configuration file
└── README.md       # Documentation
```

## Running the Project

1. Start your local PHP server (XAMPP/WAMP/MAMP)
2. Place the project in the server's web root directory
3. Access the website through your browser:
   ```
   http://localhost/weather-reporter-website
   ```

## Development

To start development with automatic SCSS compilation and live updates:

1. Open terminal in project directory
2. Run SCSS watcher:
   ```bash
   sass --watch assets/scss/main.scss:assets/css/main.css
   ```
3. Make changes to SCSS files in `assets/scss/`
4. Changes will automatically compile to `assets/css/main.css`

## Dependencies

### PHP Dependencies (via Composer)
- DotEnv

### Frontend Dependencies (via npm)
- Bootstrap
- Font Awesome

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Acknowledgments

- WeatherAPI.com for providing the weather data
- Bootstrap team for the framework
- Font Awesome for the icons
