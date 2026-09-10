<?php

require_once "db.php";


// ==========================================
// ONLY ALLOW POST REQUESTS
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../register.html");
    exit();

}


// ==========================================
// GET FORM DATA
// ==========================================

$full_name = trim($_POST["full_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";

$basket02 = $_POST["basket02"] ?? "";
$basket03 = $_POST["basket03"] ?? "";

$terms = isset($_POST["terms"]);


// ==========================================
// BASIC VALIDATION
// ==========================================

if (
    empty($full_name) ||
    empty($email) ||
    empty($username) ||
    empty($password) ||
    empty($confirm_password) ||
    empty($basket02) ||
    empty($basket03)
) {

    die("Please fill in all required fields.");

}

if (!$terms) {

    die("You must agree to the Terms and Conditions.");

}

// ==========================================
// CHECK EMAIL
// ==========================================

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    die("Please enter a valid email address.");

}


// ==========================================
// CHECK PASSWORD
// ==========================================

if ($password !== $confirm_password) {

    die("Passwords do not match.");

}


if (strlen($password) < 8) {

    die("Password must contain at least 8 characters.");

}


// ==========================================
// CHECK EMAIL / USERNAME
// ==========================================

$check_sql = "SELECT user_id FROM users
              WHERE email = ? OR username = ?
              LIMIT 1";

$check_stmt = $conn->prepare($check_sql);

$check_stmt->bind_param(
    "ss",
    $email,
    $username
);

$check_stmt->execute();

$check_result = $check_stmt->get_result();


if ($check_result->num_rows > 0) {

    die("Email or username already exists.");

}

$check_stmt->close();

// ==========================================
// START DATABASE TRANSACTION
// ==========================================

$conn->begin_transaction();


// ==========================================
// HASH PASSWORD
// ==========================================

$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);


// ==========================================
// INSERT STUDENT INTO USERS
// ==========================================

$user_sql = "INSERT INTO users
             (full_name, email, username, password, role)
             VALUES (?, ?, ?, ?, 'student')";

$user_stmt = $conn->prepare($user_sql);

$user_stmt->bind_param(
    "ssss",
    $full_name,
    $email,
    $username,
    $hashed_password
);


if (!$user_stmt->execute()) {

    die("Registration failed: " . $user_stmt->error);

}


// Get newly created user ID

$user_id = $conn->insert_id;

$user_stmt->close();


// ==========================================
// SUBJECT ID MAPPING
// ==========================================

// SFT is compulsory
$sft_id = 1;


// Basket 02
if ($basket02 === "ET") {

    $basket02_id = 2;

} elseif ($basket02 === "BST") {

    $basket02_id = 3;

} else {

    die("Invalid Basket 02 subject.");

}


// Basket 03
if ($basket03 === "ICT") {

    $basket03_id = 4;

} elseif ($basket03 === "Agriculture") {

    $basket03_id = 5;

} else {

    die("Invalid Basket 03 subject.");

}


// ==========================================
// INSERT SELECTED SUBJECTS
// ==========================================

$subject_sql = "INSERT INTO student_subjects
                (user_id, subject_id)
                VALUES (?, ?)";

$subject_stmt = $conn->prepare($subject_sql);


// SFT

$subject_stmt->bind_param(
    "ii",
    $user_id,
    $sft_id
);

$subject_stmt->execute();


// Basket 02

$subject_stmt->bind_param(
    "ii",
    $user_id,
    $basket02_id
);

$subject_stmt->execute();


// Basket 03

$subject_stmt->bind_param(
    "ii",
    $user_id,
    $basket03_id
);

$subject_stmt->execute();


$subject_stmt->close();

$conn->commit();

// ==========================================
// REGISTRATION SUCCESS
// ==========================================

header("Location: ../login.html?registered=success");
exit();

?>