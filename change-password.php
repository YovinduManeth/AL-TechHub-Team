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


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Change Password - A/L TechHub</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    <!-- Project CSS -->

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>

<!-- ==============================
     Top Navigation
================================ -->

<nav class="navbar navbar-light bg-white sticky-top dashboard-navbar">

    <div class="container">

        <a
            class="navbar-brand fw-bold dashboard-brand"
            href="dashboard.php"
        >
            <i class="bi bi-mortarboard-fill me-1"></i>
            A/L TechHub
        </a>


        <div class="d-flex align-items-center gap-3">

            <a
                href="profile.php"
                class="dashboard-user text-decoration-none"
            >
                <i class="bi bi-person-circle me-1"></i>
                Profile
            </a>


            <!-- Day / Night Mode -->

            <button
                type="button"
                id="themeToggle"
                class="btn btn-link theme-toggle"
                aria-label="Switch to night mode"
                title="Switch to night mode"
            >

                <i
                    class="bi bi-moon"
                    id="themeIcon"
                ></i>

            </button>


            <!-- Logout -->

            <a
                href="php/logout.php"
                class="btn btn-outline-primary btn-sm px-3"
            >

                <i class="bi bi-box-arrow-right me-1"></i>
                Logout

            </a>

        </div>

    </div>

</nav>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7 col-md-9">


            <!-- PAGE HEADER -->

            <div class="text-center mb-4">

                <div class="profile-avatar mb-3">

                    <i class="bi bi-key"></i>

                </div>

                <h2 class="fw-bold">
                    Change Password
                </h2>

                <p class="text-muted">
                    Update your account password securely
                </p>

            </div>


            <!-- PASSWORD FORM -->

            <div class="card border-0 shadow-sm password-card">

                <div class="card-body p-4 p-md-5">


                    <?php if (isset($error)): ?>

                        <div
                            class="alert alert-danger"
                            role="alert"
                        >

                            <i class="bi bi-exclamation-circle me-2"></i>

                            <?php echo htmlspecialchars($error); ?>

                        </div>

                    <?php endif; ?>


                    <?php if (isset($success)): ?>

                        <div
                            class="alert alert-success"
                            role="alert"
                        >

                            <i class="bi bi-check-circle me-2"></i>

                            <?php echo htmlspecialchars($success); ?>

                        </div>

                    <?php endif; ?>


                    <form
                        method="POST"
                        action="change-password.php"
                    >


                        <!-- CURRENT PASSWORD -->

                        <div class="mb-4">

                            <label
                                for="current_password"
                                class="form-label fw-semibold"
                            >
                                Current Password
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    class="form-control"
                                    required
                                >

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('current_password', this)"
                                    aria-label="Show current password"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                        </div>


                        <!-- NEW PASSWORD -->

                        <div class="mb-4">

                            <label
                                for="new_password"
                                class="form-label fw-semibold"
                            >
                                New Password
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    id="new_password"
                                    name="new_password"
                                    class="form-control"
                                    minlength="8"
                                    required
                                >

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('new_password', this)"
                                    aria-label="Show new password"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                            <div class="form-text">
                                Password must contain at least 8 characters.
                            </div>

                        </div>


                        <!-- CONFIRM PASSWORD -->

                        <div class="mb-4">

                            <label
                                for="confirm_password"
                                class="form-label fw-semibold"
                            >
                                Confirm New Password
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    id="confirm_password"
                                    name="confirm_password"
                                    class="form-control"
                                    minlength="8"
                                    required
                                >

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('confirm_password', this)"
                                    aria-label="Show confirm password"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                        </div>


                        <!-- BUTTONS -->

                        <div class="d-flex gap-2 flex-wrap">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="bi bi-shield-check me-1"></i>

                                Change Password

                            </button>


                            <a
                                href="profile.php"
                                class="btn btn-outline-secondary"
                            >

                                <i class="bi bi-x-lg me-1"></i>

                                Cancel

                            </a>

                        </div>


                        </form>

                </div>

            </div>


            <!-- BACK TO DASHBOARD -->

            <div class="text-center mt-4">

                <a
                    href="dashboard.php"
                    class="text-decoration-none"
                >

                    <i class="bi bi-arrow-left me-1"></i>

                    Back to Dashboard

                </a>

            </div>


        </div>

    </div>

</div>

<script>

function togglePassword(fieldId, button) {

    const field = document.getElementById(fieldId);
    const icon = button.querySelector("i");

    if (field.type === "password") {

        field.type = "text";

        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");

        button.setAttribute(
            "aria-label",
            "Hide password"
        );

    } else {

        field.type = "password";

        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");

        button.setAttribute(
            "aria-label",
            "Show password"
        );

    }

}

</script>

<script src="./js/script.js"></script>

</body>

</html>


