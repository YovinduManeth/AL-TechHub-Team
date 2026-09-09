<?php

require_once "php/db.php";

$message = "";
$message_type = "";


// ==========================================
// FORM SUBMISSION
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");


    // ==========================================
    // BASIC VALIDATION
    // ==========================================

    if (empty($email)) {

        $message = "Please enter your email address.";
        $message_type = "danger";

    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $message_type = "danger";

    }

    else {

        // ==========================================
        // FIND USER
        // ==========================================

        $sql = "SELECT user_id, full_name
                FROM users
                WHERE email = ?
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();


        // ==========================================
        // USER FOUND
        // ==========================================

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            $user_id = $user["user_id"];


            // ==========================================
            // GENERATE RESET TOKEN
            // ==========================================

            $token = bin2hex(random_bytes(32));


            // Token expires after 15 minutes

            $expires_at =
                date(
                    "Y-m-d H:i:s",
                    time() + (15 * 60)
                );


            // ==========================================
            // DELETE OLD TOKENS
            // ==========================================

            $delete_sql =
                "DELETE FROM password_resets
                 WHERE user_id = ?";

            $delete_stmt =
                $conn->prepare($delete_sql);

            $delete_stmt->bind_param(
                "i",
                $user_id
            );

            $delete_stmt->execute();

            $delete_stmt->close();


            // ==========================================
            // SAVE NEW TOKEN
            // ==========================================

            $insert_sql =
                "INSERT INTO password_resets
                 (
                     user_id,
                     token,
                     expires_at
                 )
                 VALUES (?, ?, ?)";

            $insert_stmt =
                $conn->prepare($insert_sql);

            $insert_stmt->bind_param(
                "iss",
                $user_id,
                $token,
                $expires_at
            );


            if ($insert_stmt->execute()) {