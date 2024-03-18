<?php

$localhost = "localhost";
$username = "skill";
$password = "SCknl*t.&aMn";
$database = "skill_development";

// Create database connection
$conn = mysqli_connect($localhost, $username, $password, $database);

// Check if database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize error array
$errors = array();

function sendMail($to, $first_name) { 
    $subject = "Registration Confirmation";
    $message = "<p>Dear $first_name,</p>\n";
    $message .= "<p>Thank you for registering for our free webinar:</p>\n";
    $message .= "<h1>KiteCareer-Carving Your Career Path</h1>\n";
    $message .= "<p>Saturday, March 16 2024, 10:00 AM - 1:00 PM IST</p>\n";
    $message .= "<P>Join this <b>FREE</b> Webinar & see how you can kick start your career</P>\n";
    $message .= "<P>Regards</P>\n";
    $message .= "<P>KiteCareer</P>\n";

    $headers = "From: kitecareer\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "<script> alert('Mail sent successfully'); </script>";
    } else {
        echo $to;
        echo $subject;
        echo $message;
        echo $headers;
        echo $first_name;
        
    }
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile_no'];
    $degree = $_POST['degree'];
    $college = $_POST['college'];
    $year = $_POST['year'];
    $department = $_POST['department'];
    $city = $_POST['city'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Validate form data
    if (empty($first_name)) {
        $errors['first_name'] = "First Name is required";
    }
    if (empty($last_name)) {
        $errors['last_name'] = "Last Name is required";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } else {
        // Check if email already exists in the database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $errors['email'] = "Email address already exists. Please choose a different one.";
        }
    }
    if (empty($mobile_no)) {
        $errors['mobile_no'] = "Mobile Number is required";
    } elseif (!preg_match("/^[7-9][0-9]{9}$/", $mobile_no)) {
        $errors['mobile_no'] = "Invalid Mobile number format";
    }
    if (empty($gender)) {
        $errors['gender'] = "Gender is required";
    }
    if (empty($college)) {
        $errors['college'] = "College is required";
    }
    if (empty($year)) {
        $errors['year'] = "Year is required";
    }
    if (empty($department)) {
        $errors['department'] = "Department is required";
    }
    if (empty($degree)) {
        $errors['degree'] = "Degree is required";
    }

    // If no errors, insert data into database and send email
    if (empty($errors)) {
        // Generate a unique user_id
        $user_id = sprintf("%08d", rand(1, 99999999));

        // Insert data into database
        $sql = "INSERT INTO users (user_id, first_name, last_name, email, mobile_no, gender, college, year, degree, department, city) 
                VALUES ('$user_id', '$first_name', '$last_name', '$email', '$mobile_no', '$gender', '$college', '$year', '$degree', '$department', '$city')";
        $run = mysqli_query($conn, $sql);

        if ($run === TRUE) {
            // Send email to admin
            $admin_email = "kitecareer@gmail.com";
            $admin_subject = "Registration Form Submission";
            $admin_message = "A new user has submitted the registration form.\n\n";
            $admin_message .= "User ID: $user_id\n";
            $admin_message .= "Name: $first_name $last_name\n";
            $admin_message .= "Email: $email\n";
            $admin_message .= "Mobile Number: $mobile_no\n";
            $admin_message .= "Gender: $gender\n";
            $admin_message .= "College: $college\n";
            $admin_message .= "Year: $year\n";
            $admin_message .= "Degree: $degree\n";
            $admin_message .= "Department: $department\n";
            $admin_message .= "City: $city\n";

            $admin_headers = "From: kitecareer";

            if (mail($admin_email, $admin_subject, $admin_message, $admin_headers)) {
                // Send confirmation email to user
                sendMail($email, $first_name);
            } else {
                // Error sending mail to admin
                echo "Error sending mail to admin";
            }
        } else {
            // Error inserting data into database
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>





<!-- HTML form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Registration Form</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Image Column with Animation -->
        <div class="col-lg-7 overflow-hidden animate__animated animate__fadeInLeft">
            <img src="image/kite1.jpg" alt="kite" class="img-fluid"> 
        </div>
        <div class="col-lg-5">
            <div class="form-style animate__animated animate__fadeInRight">
                <h2 class="title">Registration Form</h2>
                <form method="POST" action="">
                    <div class="row form-group">
<div class="col">
<label for="formGroupExampleInput">First Name</label>
<input type="text" class="form-control" placeholder="First name" name="first_name">
<?php if (isset($error['first_name'])) echo "<span class='error'>* " . $error['first_name'] . "</span>"; ?>
</div>
<div class="col">
<label for="formGroupExampleInput">Last Name</label>
<input type="text" class="form-control" placeholder="Last name" name="last_name">
<?php if (isset($error['last_name'])) echo "<span class='error'>* " . $error['last_name'] . "</span>"; ?>
</div>
</div>
<div class="form-group">
<label for="formGroupExampleInput">Email</label>
<input type="text" class="form-control" name="email" placeholder="example@gmail.com">
<?php if (isset($error['email'])) echo "<span class='error'>* " . $error['email'] . "</span>"; ?>
</div>
<div class="form-group">
<label for="formGroupExampleInput2">Mobile No</label>
<input type="text" class="form-control" name="mobile_no" placeholder="123-456-7890">
<?php if (isset($error['mobile_no'])) echo "<span class='error'>* " . $error['mobile_no'] . "</span>"; ?>
</div>
<div class="form-group">
<label>Gender:</label>
<input type="radio" id="male" name="gender" value="Male">
<label for="male">Male</label>
<input type="radio" id="female" name="gender" value="Female">
<label for="female">Female</label>
<input type="radio" id="other" name="gender" value="Other">
<label for="other">Other</label>
<?php if (isset($error['gender'])) echo "<span class='error'>* " . $error['gender'] . "</span>"; ?>
</div>
<div class="form-group">
<label for="formGroupExampleInput">College</label>
<input type="text" class="form-control" name="college" placeholder="Enter Your College Name">
<?php if (isset($error['college'])) echo "<span class='error'>* " . $error['college'] . "</span>"; ?>
</div>
<div class="form-group">
<label for="year">Passed out:</label>
<select name="year" id="year">
<optgroup label="---select option---">
<option value="select">---select---</option>
<option value="studing">studying</option>
</optgroup>
<optgroup label="passed-out">
<option value="2023">2023</option>
<option value="2022">2022</option>
<option value="2021">2021</option>
<option value="2020">2020</option>
<option value="2019">2019</option>
<option value="2018">2018</option>
<option value="2017">2017</option>
<option value="2016">2016</option>
<option value="2015">2015</option>
</optgroup>
</select>
<?php if (isset($error['year'])) echo "<span class='error'>* " . $error['year'] . "</span>"; ?>
</div>
<div class="form-group">
<label for="formGroupExampleInput2">Degree</label>
<input type="text" class="form-control" name="degree">
<?php if (isset($error['degree'])) echo "<span class='error'>* " . $error['degree'] . "</span>"; ?>
</div>
<div class="form-group">
<label for="formGroupExampleInput">Department</label>
<input type="text" class="form-control" name="department">
<?php if (isset($error['department'])) echo "<span class='error'>* " . $error['department'] . "</span>"; ?>
</div>
<div class="form-group">
<label for="formGroupExampleInput2">City / District</label>
<input type="text" class="form-control" name="city" placeholder="Tenkasi">
<?php if (isset($error['city'])) echo "<span class='error'>* " . $error['city'] . "</span>"; ?>
</div><br>
<button type="submit" name="submit" class="btn btn-primary form-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
