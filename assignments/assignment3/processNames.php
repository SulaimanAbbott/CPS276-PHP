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

        // Check if array is not empty, then populate it
        if (!empty($_POST['namelist'])) {
            $names = explode("\n", $_POST['namelist']);
        }

        // Split the name into two parts
        [$first, $last] = explode(" ", $_POST['name']);

        // Flip the order and add to array
        $names[] = "$last, $first";

        // Sort names alphabetically
        sort($names);
        
        // Combine names into single line 
        return implode("\n", $names);
    }

    return "";
}
