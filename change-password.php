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
// CHANGE PASSWORD
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $current_password = $_POST["current_password"] ?? "";
    $new_password = $_POST["new_password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";


    // ==========================================
    // BASIC VALIDATION
    // ==========================================

    if (
        empty($current_password) ||
        empty($new_password) ||
        empty($confirm_password)
    ) {

        $error = "Please fill in all fields.";

    } elseif (strlen($new_password) < 8) {

        $error = "New password must contain at least 8 characters.";

    } elseif ($new_password !== $confirm_password) {

        $error = "New passwords do not match.";

    } else {


        // ==========================================
        // GET CURRENT PASSWORD
        // ==========================================

        $sql = "SELECT password
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

            $error = "User account not found.";

        } else {

            $user = $result->fetch_assoc();

            $stored_password = $user["password"];


            // ==========================================
            // VERIFY CURRENT PASSWORD
            // ==========================================

            if (!password_verify($current_password, $stored_password)) {

                $error = "Current password is incorrect.";

            } elseif (password_verify($new_password, $stored_password)) {

                $error = "New password must be different from your current password.";

            } else {


                // ==========================================
                // HASH NEW PASSWORD
                // ==========================================

                $hashed_password = password_hash(
                    $new_password,
                    PASSWORD_DEFAULT
                );


                // ==========================================
                // UPDATE PASSWORD
                // ==========================================

                $update_sql = "UPDATE users
                               SET password = ?
                               WHERE user_id = ?";

                $update_stmt = $conn->prepare($update_sql);

                $update_stmt->bind_param(
                    "si",
                    $hashed_password,
                    $user_id
                );


                if ($update_stmt->execute()) {

                    $success = "Password changed successfully.";

                } else {

                    $error = "Failed to change password.";

                }

                $update_stmt->close();

            }

        }

        $stmt->close();

    }

}

?>