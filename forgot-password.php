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

             // ==========================================
                // DEVELOPMENT RESET LINK
                // ==========================================

                $reset_link =
                    "reset-password.php?token=" .
                    urlencode($token);


        
                    $message =
                        "Reset link generated successfully." .
                        "<br><br>" .
                        "<strong>Development Reset Link:</strong>" .
                        "<div style=\"margin-top: 8px; overflow-wrap: anywhere; word-break: break-word;\">" .
                            "<a href=\"" .
                            htmlspecialchars($reset_link) .
                            "\" style=\"display: inline-block;\">" .
                            htmlspecialchars($reset_link) .
                            "</a>" .
                        "</div>" .
                        "<br>" .
                        "<small>This link will expire in 15 minutes.</small>";



                $message_type = "success";

            }

            else {

                $message =
                    "Unable to create password reset link.";

                $message_type = "danger";

            }


            $insert_stmt->close();

        }

        else {

            // Don't reveal whether an account exists.

            $message =
                "If an account exists with that email address, " .
                "a password reset link has been generated.";

            $message_type = "success";

        }


        $stmt->close();

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Forgot Password | A/L TechHub</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    <!-- Main CSS -->

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body class="login-page">


<div class="login-wrapper">

<!-- =========================================
         LEFT SIDE
    ========================================== -->

    <div class="login-sidebar">

        <div class="login-sidebar-content">


            <!-- Logo -->

            <a
                href="index.html"
                class="login-logo text-decoration-none"
            >

                <i class="bi bi-mortarboard-fill me-2"></i>

                A/L TechHub

            </a>


            <!-- Main Content -->

            <div class="login-sidebar-main">

                <span class="login-sidebar-label">
                    ACCOUNT RECOVERY
                </span>


                <h1>

                    Reset Your
                    <span>Password.</span>

                </h1>


                <p>

                    Recover access to your A/L TechHub
                    student account and continue your
                    learning journey.

                </p>


                <!-- Benefits -->

                <div class="login-benefits">


                    <div class="login-benefit">

                        <div class="login-benefit-icon">

                            <i class="bi bi-shield-check"></i>

                        </div>

                        <div>

                            <strong>Secure Recovery</strong>

                            <small>
                                Use a temporary reset link
                                to change your password.
                            </small>

                        </div>

                    </div>


                    <div class="login-benefit">

                        <div class="login-benefit-icon">

                            <i class="bi bi-clock"></i>

                        </div>

                        <div>

                            <strong>Time Limited</strong>

                            <small>
                                Reset links expire after
                                a short period.
                            </small>

                        </div>

                    </div>


                    <div class="login-benefit">

                        <div class="login-benefit-icon">

                            <i class="bi bi-lock"></i>

                        </div>

                        <div>

                            <strong>Protected Password</strong>

                            <small>
                                New passwords are securely
                                hashed before storage.
                            </small>

                        </div>

                    </div>


                </div>

            </div>


            <!-- Footer -->

            <div class="login-sidebar-footer">

                &copy; 2026 A/L TechHub

            </div>


        </div>

    </div>

