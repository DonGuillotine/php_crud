<?php

// Check if the ID exists before proceding

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = ?";

    if($stmt = mysqli_prepare($connection, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set Parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepare statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                // Fetch result row as an associative array.
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve Individual field value
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            }
            else{
                // URL doesn't contain valid the id parameter. Redirect to an error page
                header("location: error.php");
                exit();
            }
        }
        else{
            echo "Something went wrong";
        }
    }
    // Close Statement
    mysqli_stmt_close($stmt);

    // Close Connection
    mysqli_close($connection);
}
else{
    header("location: error.php");
    exit();
}