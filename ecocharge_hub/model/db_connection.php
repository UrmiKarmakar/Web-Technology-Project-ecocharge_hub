<?php

// Default: values in a server application
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "ecocharge_hub"; // Your project database name, adjust accordingly

//v1.0.1- Establish a global database db_connect
function db_connect() {
    global $db_server, $db_user, $db_pass, $db_name;

    // Establish a db_connect to the database
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    // Handle db_connect errors
    if (mysqli_connect_errno()) {
        return null;
    }
    return $conn;
}

//v1.0.1- Closing The db_connect
function db_close($conn) { 
    mysqli_close($conn);
 }
 

// Function to execute queries that modify data (Insert, Update, Delete)
function execute($query)
{
    $conn = db_connect();
    
    if ($conn) {
        if (mysqli_query($conn, $query)) {
            mysqli_close($conn);  // Close the db_connect after query execution
            return true;
        } else {
            mysqli_close($conn);  //v1.0.1- Close the db_connect after query execution
            return mysqli_error($conn);  // Return error message if query fails
        }
    } else {
        return "Database db_connect failed: " . mysqli_connect_error();
    }
}

// Function to get data (Select query)
function get($query)
{
    $conn = db_connect();
    $data = array();

    if ($conn) {
        $result = mysqli_query($conn, $query);

        // Fetch all rows from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; // Add each row to the data array
        }

        mysqli_free_result($result); // Free result set memory
        mysqli_close($conn);  //v1.0.1- Close the db_connect after the query
    } else {
        return "Database db_connect failed: " . mysqli_connect_error();
    }

    // Return the array of data
    return $data;
}

?>
