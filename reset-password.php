<?php

require_once "php/db.php";


// ==========================================
// VARIABLES
// ==========================================

$message = "";
$message_type = "";

$token = $_GET["token"] ?? "";


// ==========================================
// CHECK TOKEN
// ==========================================

if (empty($token)) {

    $message = "Invalid or missing password reset token.";
    $message_type = "danger";

}


// ==========================================
// FIND TOKEN
// ==========================================

if (!empty($token)) {

    $sql = "SELECT
                password_resets.id,
                password_resets.user_id,
                password_resets.expires_at,
                users.email
            FROM password_resets
            INNER JOIN users
                ON password_resets.user_id = users.user_id
            WHERE password_resets.token = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "s",
        $token
    );

    $stmt->execute();

    $result = $stmt->get_result();


    // ==========================================
    // TOKEN NOT FOUND
    // ==========================================

    if ($result->num_rows === 0) {

        $message =
            "This password reset link is invalid or has already been used.";

        $message_type = "danger";

    }

    else {

        $reset = $result->fetch_assoc();


        // ==========================================
        // CHECK EXPIRATION
        // ==========================================

        if (
            strtotime($reset["expires_at"]) < time()
        ) {

            $message =
                "This password reset link has expired. " .
                "Please request a new one.";

            $message_type = "danger";


            // Delete expired token

            $delete_sql =
                "DELETE FROM password_resets
                 WHERE id = ?";

            $delete_stmt =
                $conn->prepare($delete_sql);

            $delete_stmt->bind_param(
                "i",
                $reset["id"]
            );

            $delete_stmt->execute();

            $delete_stmt->close();

        }

    }


    $stmt->close();

}


// ==========================================
// PROCESS NEW PASSWORD
// ==========================================

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    !empty($token) &&
    empty($message)
) {

    $password =
        $_POST["password"] ?? "";

    $confirm_password =
        $_POST["confirm_password"] ?? "";

        // ==========================================
    // CHECK PASSWORDS
    // ==========================================

    if (
        empty($password) ||
        empty($confirm_password)
    ) {

        $message =
            "Please enter and confirm your new password.";

        $message_type = "danger";

    }

    elseif ($password !== $confirm_password) {

        $message =
            "The passwords do not match.";

        $message_type = "danger";

    }

    elseif (strlen($password) < 8) {

        $message =
            "Password must contain at least 8 characters.";

        $message_type = "danger";

    }

    else {


        // ==========================================
        // HASH NEW PASSWORD
        // ==========================================

        $hashed_password =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );


        // ==========================================
        // UPDATE USER PASSWORD
        // ==========================================

        $update_sql =
            "UPDATE users
             SET password = ?
             WHERE user_id = ?";

        $update_stmt =
            $conn->prepare($update_sql);

        $update_stmt->bind_param(
            "si",
            $hashed_password,
            $reset["user_id"]
        );


        // ==========================================
        // SAVE PASSWORD
        // ==========================================

        if ($update_stmt->execute()) {


            // ==========================================
            // DELETE USED TOKEN
            // ==========================================

            $delete_sql =
                "DELETE FROM password_resets
                 WHERE id = ?";

            $delete_stmt =
                $conn->prepare($delete_sql);

            $delete_stmt->bind_param(
                "i",
                $reset["id"]
            );

            $delete_stmt->execute();

            $delete_stmt->close();