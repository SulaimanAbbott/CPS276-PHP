<?php
function addClearNames() {
    // Clear names if clearNames button is pressed
    if (isset($_POST['clearNames'])) {
        return "";
    }
    
    // Add name if addName button is pressed
    if (isset($_POST['addName'])) {

        // Empty array to hold names
        $names = [];

        // If the textarea already has names, split them into an array
        if (!empty($_POST['namelist'])) {
            $names = explode("\n", $_POST['namelist']);
        }

        // Split the input name into first and last
        [$first, $last] = explode(" ", $_POST['name']);

        // Flip the order and push into the array
        array_push($names, "$last, $first");

        // Sort names alphabetically
        sort($names);
        
        // Combine names into one string, each on a new line
        return implode("\n", $names);
    }

    // If no button was pressed, return empty string
    return "";
}
