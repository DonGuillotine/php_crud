<?php 
    // Include Config file
    require_once "config.php";

    // Define variables and give them empty values
    $name = $address = $salary = "";
    $name_err = $address_err = $salary_err = "";

    // Process the form data when the form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validate name
        $input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Please enter a Name.";
        }
        // Makes sure a user enters a valid name
        // The regular expression pattern "/^[a-zA-Z\s]+$/" only allows letters (uppercase or lowercase) and spaces in the input. 
        elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-sA-Z\s]+$/")))){
            $name_err = "Please enter a Valid name";
        }
        else{
            $name = $input_name;
        }

        // Validate Address
        $input_address = trim($_POST["address"]);
        if(empty($input_address)){
            $address_err = "Please enter an address";
        }
        else{
            $address = $input_address;
        }


        // Validate Salary
        $input_salary = trim($_POST["salary"]);
        if(empty($input_salary)){
            $salary_err = "Please enter the Salary amount.";
        }
        elseif(!ctype_digit($input_salary)){
            $salary_err = "Please enter a valid amount.";
        }
        else{
            $salary = $input_salary;
        }

        // PREPARED STATEMENTS

        // Check for input errors before inserting into database
        if(empty($name_err) && empty($address_err) && empty($salary_err)){
            // Prepare an insert statement
            $sql = "INSERT INTO employees (name, address, salary) VALUES(?, ?, ?)";

            if($stmt = mysqli_prepare($connection, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);

                // Set Parameters
                $param_name = $name;
                $param_address = $address;
                $param_salary = $salary;

                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Successful. Redirect to landing_page
                    header("location: landing_page.php");
                    exit();
                }else{
                    echo "Something went wrong";
                }
            }

        //Close Statement
        mysqli_stmt_close($stmt);
    }

    // Close Connection
    mysqli_close($connection);
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
