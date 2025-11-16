<?php
function getWeather() {
    $acknowledgement = "";
    $output = "";

    if (empty($_POST['zip_code'])) {
        $acknowledgement = "<p>No zip code provided. Please enter a zip code.</p>";
        return [$acknowledgement, $output];
    }

    $zip = htmlspecialchars($_POST['zip_code']);
    $url = "https://russet-v8.wccnet.edu/~sshaper/assignments/assignment10_rest/get_weather_json.php?zip_code={$zip}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $acknowledgement = "<p>There was an error retrieving the records.</p>";
        curl_close($ch);
        return [$acknowledgement, $output];
    }

    curl_close($ch);
    $data = json_decode($response, true);

    if (isset($data['error'])) {
        $acknowledgement = "<p>{$data['error']}</p>";
        return [$acknowledgement, $output];
    }
    
    $higher = isset($data['higher_temperatures']) ? $data['higher_temperatures'] : [];
    $lower = isset($data['lower_temperatures']) ? $data['lower_temperatures'] : [];

    // search data
    $city = $data['searched_city']['name'];
    $temp = $data['searched_city']['temperature'];
    $humidity = $data['searched_city']['humidity'];
    $forecast = $data['searched_city']['forecast'];

    // display search
    $output .= "<h2>{$city}</h2>";
    $output .= "<p><strong>Temperature:</strong> {$temp}</p>";
    $output .= "<p><strong>Humidity:</strong> {$humidity}</p>";
    $output .= "<p><strong>3-day forecast</strong></p><ul>";
    foreach ($forecast as $day) {
        $output .= "<li>{$day['day']}: {$day['condition']}</li>";
    }
    $output .= "</ul>";

    // Higher temperatures
    if (!empty($higher)) {
        $output .= "<p><strong>Up to three cities where temperatures are higher than {$city}</strong></p>";
        $output .= "<table class='table table-striped'><thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>";
        foreach ($higher as $entry) {
            $output .= "<tr><td>{$entry['name']}</td><td>{$entry['temperature']}</td></tr>";
        }
        $output .= "</tbody></table>";
    } else {
        $output .= "<p><strong>There are no cities with higher temperatures than {$city}</strong></p>";
    }

    // Lower temperatures
    if (!empty($lower)) {
        $output .= "<p><strong>Up to three cities where temperatures are lower than {$city}</strong></p>";
        $output .= "<table class='table table-striped'><thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>";
        foreach ($lower as $entry) {
            $output .= "<tr><td>{$entry['name']}</td><td>{$entry['temperature']}</td></tr>";
        }
        $output .= "</tbody></table>";
    } else {
        $output .= "<p><strong>There are no cities with lower temperatures than {$city}</strong></p>";
    }

    return [$acknowledgement, $output];
}
?>