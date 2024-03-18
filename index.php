<?php
session_start();

$localhost = "localhost";
$username = "skill";
$password = "SCknl*t.&aMn";
$database = "skill_development";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create database connection
$conn = mysqli_connect($localhost, $username, $password, $database);

// Check if database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    // Clear the session variable
    unset($_SESSION['success_message']);
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
    $message .= "<P>Regards,</P>\n";
    $message .= "<P>KiteCareer</P>\n";

    $headers = "From: kitecareer\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
    // Set session variables to store data for the next page
    $_SESSION['success_message'] = "Mail sent successfully";
    // Clear form data
    $first_name = $lastname = $email = $mobile_no = $degree = $college = $year = $department = $city = $date = $gender = "";
    // Redirect to index.php
    header("Location: index.php");
    exit(); // Ensure that no further PHP code is executed
}
else {
        echo "<script> alert('Mail not sent,Please check it'); </script>";
        
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
    $date = $_POST['dob'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Validate form data
//     if (empty($first_name)) {
//         $errors['first_name'] = "First Name is required";
//     }
//     if (!empty($first_name) && empty($last_name)) {
//         $errors['last_name'] = "Last Name is required";
//     }
//     if (empty($email)) {
//         $errors['email'] = "Email is required";
//     } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $errors['email'] = "Invalid email format";
//     } else {
//         // Check if email already exists in the database
//         $sql = "SELECT * FROM users WHERE email = '$email'";
//         $result = $conn->query($sql);

//         if ($result->num_rows > 0) {
//             $errors['email'] = "Email address already exists. Please choose a different one.";
//         }
//     }
//     if (empty($mobile_no)) {
//         $errors['mobile_no'] = "Mobile Number is required";
//     } elseif (!preg_match("/^[7-9][0-9]{9}$/", $mobile_no)) {
//         $errors['mobile_no'] = "Invalid Mobile number format";
//     }
//     if (empty($gender)) {
//         $errors['gender'] = "Gender is required";
//     }
//   if (empty($date)) {
//     $errors['dob'] = "Date of Birth is required";
// } 


//     if (empty($college)) {
//         $errors['college'] = "College is required";
//     }
//     if (empty($year)) {
//         $errors['year'] = "Year is required";
//     }
//     if (empty($department)) {
//         $errors['department'] = "Department is required";
//     }
//     if (empty($degree)) {
//         $errors['degree'] = "Degree is required";
//     }

    // If no errors, insert data into database and send email
    if (empty($errors)) {
        // Generate a unique user_id
        $user_id = sprintf("%08d", rand(10000000, 99999999));

        // Insert data into database
        $sql = "INSERT INTO users (user_id, first_name, last_name, email, mobile_no, gender, dob,college, year, degree, department, city) 
                VALUES ('$user_id', '$first_name', '$last_name', '$email', '$mobile_no', '$gender', '$date', '$college', '$year', '$degree', '$department', '$city')";
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
            $admin_message .= "Date of Birth: $date\n";
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        @media (max-width: 768px) {
            .col-md-12 {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
        @media (min-width: 800px) {
            h1 {
                margin-top: 190px;
            }
        }
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <img class="img-fluid" src="image/Frame 33952.png" alt="Logo">
            </div>
            <div class="col-md-6">
                <h1 class="text-center" style="color:#0E4A67">WEBINAR REGISTRATION FORM</h1>
            </div>
        </div>
        <form action="" method="POST" id="registrationForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First name">
                    <span id="firstNameError" class="error"></span>
                </div>
                <div class="col-md-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last name" >
                    <span id="lastNameError" class="error"></span>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email address">
                <span id="emailError" class="error"></span>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="gender" name="gender" class="form-select" >
                        <option value="">Select...</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <span id="genderError" class="error"></span>
                </div>
                <div class="col-md-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" >
                    <span id="dobError" class="error"></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="college" class="form-label">College Name</label>
                    <input type="text" class="form-control" id="college" name="college" placeholder="College Name" >
                    <span id="collegeError" class="error"></span>
                </div>
                <div class="col-md-6">
                    <label for="year" class="form-label">Year of Passing</label>
                    <select id="year" class="form-select" name="year" >
                        <optgroup label="---select option---">
                            <option value="select">---select---</option>
                            <option value="pursuing">pursuing</option>
                        </optgroup>
                        <optgroup label="Year of Passing">
                            <option value="2024">2024</option>
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
                    <span id="yearError" class="error"></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="degree" class="form-label">Degree</label>
                    <input type="text" class="form-control" id="degree" name="degree" placeholder="Degree" >
                    <span id="degreeError" class="error"></span>
                </div>
                <div class="col-md-6">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" class="form-control" id="department" name="department" placeholder="Department" >
                    <span id="departmentError" class="error"></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phoneNumber" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phoneNumber" name="mobile_no" placeholder="Phone number" >
                    <span id="phoneNumberError" class="error"></span>
                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label">City/District</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City/District" >
                    <span id="cityError" class="error"></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-primary btn-block submit" value="SUBMIT" name="submit" style="background:rgb(79 168 255);color:#fff;border:none;">
                </div>
            </div>
        </form>
    </div>
    
    <script>
        $(document).ready(function () {
            $("#registrationForm").submit(function (event) {
                var valid = true;

                // Clear previous errors
                $(".error").html("");

                // Check each field for validation
                if ($("#firstName").val() == "") {
                    $("#firstNameError").html("* First Name is required");
                    valid = false;
                }

                if ($("#lastName").val() == "") {
                    $("#lastNameError").html("* Last Name is required");
                    valid = false;
                }

                if ($("#email").val() == "") {
                    $("#emailError").html("* Email is required");
                    valid = false;
                } else if (!isValidEmail($("#email").val())) {
                    $("#emailError").html("* Invalid email format");
                    valid = false;
                }

                if ($("#phoneNumber").val() == "") {
                    $("#phoneNumberError").html("* Mobile Number is required");
                    valid = false;
                } else if (!isValidMobileNo($("#phoneNumber").val().trim())) {
                    $("#phoneNumberError").html("* Invalid Mobile number format");
                    valid = false;
                }

                if ($("#gender").val() == "") {
                    $("#genderError").html("* Gender is required");
                    valid = false;
                }

                if ($("#dob").val() == "") {
                    $("#dobError").html("* Date of Birth is required");
                    valid = false;
                }

                if ($("#college").val() == "") {
                    $("#collegeError").html("* College is required");
                    valid = false;
                }

                if ($("#year").val() == "") {
                    $("#yearError").html("* Year is required");
                    valid = false;
                }

                if ($("#degree").val() == "") {
                    $("#degreeError").html("* Degree is required");
                    valid = false;
                }

                if ($("#department").val() == "") {
                    $("#departmentError").html("* Department is required");
                    valid = false;
                }

                if ($("#city").val() == "") {
                    $("#cityError").html("* City/District is required");
                    valid = false;
                }

                if (!valid) {
                    event.preventDefault();
                }
            });

            // Function to check if the email is in valid format
            function isValidEmail(email) {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Function to check if the mobile number is in valid format
           function isValidMobileNo(mobileNo) {
        // Allow optional spaces or hyphens between digits
        var mobileNoRegex = /^[6-9][0-9]{0,2}[\s-]?[0-9]{3,4}[\s-]?[0-9]{4}$/;
        return mobileNoRegex.test(mobileNo);
           }
        });
    </script>
</body>

</html>
