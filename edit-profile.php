<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html");
    exit();

}

$user_id = $_SESSION["user_id"];


// ==========================================
// GET CURRENT USER DATA
// ==========================================

$sql = "SELECT full_name, username, email
        FROM users
        WHERE user_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {

    $stmt->close();

    session_destroy();

    header("Location: login.html");
    exit();

}

$user = $result->fetch_assoc();

$stmt->close();

// ==========================================
// UPDATE PROFILE
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");


    // ==========================================
    // BASIC VALIDATION
    // ==========================================

    if (
        empty($full_name) ||
        empty($username) ||
        empty($email)
    ) {

        $error = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {


        // ==========================================
        // CHECK USERNAME / EMAIL
        // ==========================================

        $check_sql = "SELECT user_id
                      FROM users
                      WHERE (email = ? OR username = ?)
                      AND user_id != ?
                      LIMIT 1";

        $check_stmt = $conn->prepare($check_sql);

        $check_stmt->bind_param(
            "ssi",
            $email,
            $username,
            $user_id
        );

        $check_stmt->execute();

        $check_result = $check_stmt->get_result();


        if ($check_result->num_rows > 0) {

            $error = "Email or username already exists.";

        } else {


            // ==========================================
            // UPDATE USER
            // ==========================================

            $update_sql = "UPDATE users
                           SET full_name = ?,
                               username = ?,
                               email = ?
                           WHERE user_id = ?";

            $update_stmt = $conn->prepare($update_sql);

            $update_stmt->bind_param(
                "sssi",
                $full_name,
                $username,
                $email,
                $user_id
            );


            if ($update_stmt->execute()) {


                // ==========================================
                // UPDATE SESSION
                // ==========================================

                $_SESSION["full_name"] = $full_name;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;


                $update_stmt->close();
                $check_stmt->close();
                $conn->close();


                // ==========================================
                // RETURN TO PROFILE
                // ==========================================

                header("Location: profile.php?updated=success");
                exit();

            } else {

                $error = "Failed to update profile.";

            }

            $update_stmt->close();

        }

        $check_stmt->close();

    }

}

?>