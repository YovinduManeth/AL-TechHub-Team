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

             // ==========================================
            // SUCCESS
            // ==========================================

            $message =
                "Your password has been reset successfully." .
                "<br><br>" .
                "<a href=\"login.html\" " .
                "class=\"btn btn-login-new\">" .
                "<i class=\"bi bi-box-arrow-in-right me-2\"></i>" .
                "Go to Login" .
                "</a>";

            $message_type = "success";


            // Prevent form from being displayed

            $token = "";

        }

        else {

            $message =
                "Unable to update your password. " .
                "Please try again.";

            $message_type = "danger";

        }


        $update_stmt->close();

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

    <title>Reset Password | A/L TechHub</title>


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
                    ACCOUNT SECURITY
                </span>


                <h1>

                    Create a
                    <span>New Password.</span>

                </h1>


                <p>

                    Choose a new password for your
                    A/L TechHub student account.

                </p>


                <div class="login-benefits">


                    <div class="login-benefit">

                        <div class="login-benefit-icon">

                            <i class="bi bi-shield-check"></i>

                        </div>

                        <div>

                            <strong>Secure Password</strong>

                            <small>
                                Your new password is securely
                                hashed before being stored.
                            </small>

                        </div>

                    </div>


                    <div class="login-benefit">

                        <div class="login-benefit-icon">

                            <i class="bi bi-key"></i>

                        </div>

                        <div>

                            <strong>Password Protection</strong>

                            <small>
                                Your existing password will
                                be replaced securely.
                            </small>

                        </div>

                    </div>


                    <div class="login-benefit">

                        <div class="login-benefit-icon">

                            <i class="bi bi-check-circle"></i>

                        </div>

                        <div>

                            <strong>Ready to Learn</strong>

                            <small>
                                Sign in with your new password
                                after resetting it.
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
    
    <!-- =========================================
         RIGHT SIDE
    ========================================== -->

    <div class="login-content">


        <div class="login-form-container">


            <!-- Heading -->

            <div class="login-heading">

                <span class="login-label">
                    ACCOUNT SECURITY
                </span>

                <h2>
                    Reset Password
                </h2>

                <p>
                    Enter your new password below.
                </p>

            </div>



            <!-- Form Card -->

            <div class="login-form-card">


                <?php if (!empty($message)): ?>

                    <div
                        class="alert alert-<?php echo $message_type; ?>"
                        role="alert"
                    >

                        <i
                            class="bi bi-info-circle-fill me-2"
                        ></i>

                        <?php echo $message; ?>

                    </div>

                <?php endif; ?>



                <?php if (!empty($token) && empty($message)): ?>

                    <form
                        method="POST"
                        action="reset-password.php?token=<?php echo urlencode($token); ?>"
                    >


                        <!-- New Password -->

                            <div class="mb-4">

                                <label
                                    for="password"
                                    class="form-label fw-semibold"
                                >
                                    New Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control"
                                        placeholder="Enter new password"
                                        minlength="8"
                                        required
                                    >

                                    <button
                                        type="button"
                                        class="input-group-text password-toggle"
                                        id="togglePassword"
                                        aria-label="Show password"
                                    >
                                        <i
                                            class="bi bi-eye"
                                            id="eyeIcon"
                                        ></i>
                                    </button>

                                </div>

                                <div class="form-text">
                                    Password must contain at least 8 characters.
                                </div>

                            </div>





                        <!-- Confirm Password -->

                  
                            <div class="mb-4">

                                <label
                                    for="confirm_password"
                                    class="form-label fw-semibold"
                                >
                                    Confirm New Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>

                                    <input
                                        type="password"
                                        name="confirm_password"
                                        id="confirm_password"
                                        class="form-control"
                                        placeholder="Confirm new password"
                                        minlength="8"
                                        required
                                    >

                                    <button
                                        type="button"
                                        class="input-group-text password-toggle"
                                        id="toggleConfirmPassword"
                                        aria-label="Show password"
                                    >
                                        <i
                                            class="bi bi-eye"
                                            id="confirmEyeIcon"
                                        ></i>
                                    </button>

                                </div>

                            </div>

                            <!-- Submit -->

                        <button
                            type="submit"
                            class="btn btn-login-new w-100"
                        >

                            <i class="bi bi-key-fill me-2"></i>

                            Reset Password

                        </button>


                    </form>

                <?php endif; ?>



                <?php if (empty($message)): ?>

                    <div class="login-redirect-new">

                        <span>
                            Remember your password?
                        </span>

                        <a
                            href="login.html"
                            class="login-link"
                        >

                            Back to Login

                            <i
                                class="bi bi-arrow-right ms-1"
                            ></i>

                        </a>

                    </div>

                <?php endif; ?>


            </div>


        </div>

    </div>


</div>


<script>

    // ==========================================
    // NEW PASSWORD TOGGLE
    // ==========================================

    const password =
        document.getElementById("password");

    const togglePassword =
        document.getElementById("togglePassword");

    const eyeIcon =
        document.getElementById("eyeIcon");


    togglePassword.addEventListener("click", function () {

        if (password.type === "password") {

            password.type = "text";

            eyeIcon.classList.remove("bi-eye");

            eyeIcon.classList.add("bi-eye-slash");

            togglePassword.setAttribute(
                "aria-label",
                "Hide password"
            );

        }

        else {

            password.type = "password";

            eyeIcon.classList.remove("bi-eye-slash");

            eyeIcon.classList.add("bi-eye");

            togglePassword.setAttribute(
                "aria-label",
                "Show password"
            );

        }

    });



    // ==========================================
    // CONFIRM PASSWORD TOGGLE
    // ==========================================

    const confirmPassword =
        document.getElementById("confirm_password");

    const toggleConfirmPassword =
        document.getElementById(
            "toggleConfirmPassword"
        );

    const confirmEyeIcon =
        document.getElementById(
            "confirmEyeIcon"
        );


    toggleConfirmPassword.addEventListener(
        "click",
        function () {

            if (confirmPassword.type === "password") {

                confirmPassword.type = "text";

                confirmEyeIcon.classList.remove(
                    "bi-eye"
                );

                confirmEyeIcon.classList.add(
                    "bi-eye-slash"
                );

                toggleConfirmPassword.setAttribute(
                    "aria-label",
                    "Hide password"
                );

            }

            else {

                confirmPassword.type = "password";

                confirmEyeIcon.classList.remove(
                    "bi-eye-slash"
                );

                confirmEyeIcon.classList.add(
                    "bi-eye"
                );

                toggleConfirmPassword.setAttribute(
                    "aria-label",
                    "Show password"
                );

            }

        }
    );

</script>



</body>

</html>

