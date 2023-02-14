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
            $products = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($products) == 1){
                // Fetch result row as an associative array.
                $row = mysqli_fetch_array($products, MYSQLI_ASSOC);

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

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p><b><?php echo $row["address"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p><b><?php echo $row["salary"]; ?></b></p>
                    </div>
                    <p><a href="landing_page.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
