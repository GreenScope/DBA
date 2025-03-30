<?php

// Database Credentials
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Import Parameters
$parameters = ['timestamp', 'ID', 'temperature', 'relative_humidity', 'absolute_humidity', 'dew_point', 'pressure', 'light', 'mq135', 'CO', 'CH4', 'smoke', 'pm2_5', 'aqi'];

// Create connection
$database = new mysqli($servername, $username, $password, $dbname);

// Check connection and terminate on error with Error Code 00
if ($database->connect_error) {
    die("E00: " . $database->connect_error);
}

function checkParameters()
{
    global $parameters, $database;

    // Check if all parameters are set in the GET request
    foreach ($parameters as $parameter) {
        if (!isset($_GET[$parameter])) {
            die("E01: Missing parameter $parameter");
        } else {
            // Escape and sanitize the parameter
            global $$parameter;
            $$parameter = $database->real_escape_string($_GET[$parameter]);

            // Validate parameter types
            switch ($parameter) {
                case 'ID':
                    // Check if ID exists in the 'Locations' table
                    $sql = "SELECT * FROM Locations WHERE ID = '$$parameter'";
                    $result = $database->query($sql);
                    // Check if the table exists
                    if ($database->errno == 1146) {
                        die("E05: " . $database->error);
                    }
                    // If there are no results
                    if ($result) {
                        if ($result->num_rows === 0) {
                            die("E02: Invalid ID");
                        }
                    } else {
                        die("EXX: " . $database->error);
                    }
                    break;

                case 'timestamp':
                    // Validate timestamp
                    if (!strtotime($$parameter)) {
                        die("E03: Invalid timestamp");
                    }
                    break;

                default:
                    // Validate floating-point numbers
                    if (!is_numeric($$parameter)) {
                        die("E04: Invalid value for $parameter. Expected a numeric value.");
                    }
                    break;
            }
        }
    }
}

// Function to decide which table to upload to
function compareTime()
{
    global $parameters, $database;
    foreach ($parameters as $parameter) {
        global $$parameter;
    }

    // Get timestamp of the latest entry in the specified location
    $sql = "SELECT `Timestamp`
            FROM Recordings
            WHERE ID = '$ID'
            ORDER BY `Timestamp` DESC
            LIMIT 1";

    $result = $database->query($sql);

    // Check if the table exists
    if ($database->errno == 1146) {
        die("E06: " . $database->error);
    }
    // If there are no results
    if ($result) {
        if ($result->num_rows === 0) {
            die("W01: No previous records found");
        }
        $tz = new DateTimeZone('Asia/Karachi');
        $row = $result->fetch_assoc();

        $storedTime = new DateTime($row['Timestamp'], $tz);
        $currentTime = new DateTime('now', $tz);

        $diff = $storedTime->diff($currentTime);
        $differenceInMinutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
        return $differenceInMinutes;
    } else {
        die("EXX: " . $database->error);
    }
}
