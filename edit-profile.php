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

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Profile - A/L TechHub</title>


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

                    <i class="bi bi-person"></i>

                </div>

                <h2 class="fw-bold">
                    Edit Profile
                </h2>

                <p class="text-muted">
                    Update your personal account information
                </p>

            </div>


            <!-- PROFILE FORM -->

            <div class="card border-0 shadow-sm profile-edit-card">

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


                    <form
                        method="POST"
                        action="edit-profile.php"
                    >


                        <!-- FULL NAME -->

                        <div class="mb-4">

                            <label
                                for="full_name"
                                class="form-label fw-semibold"
                            >
                                Full Name
                            </label>

                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                class="form-control"
                                value="<?php echo htmlspecialchars($user["full_name"]); ?>"
                                required
                            >

                        </div>


                        <!-- USERNAME -->

                        <div class="mb-4">

                            <label
                                for="username"
                                class="form-label fw-semibold"
                            >
                                Username
                            </label>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                class="form-control"
                                value="<?php echo htmlspecialchars($user["username"]); ?>"
                                required
                            >

                        </div>


                        <!-- EMAIL -->

                        <div class="mb-4">

                            <label
                                for="email"
                                class="form-label fw-semibold"
                            >
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                value="<?php echo htmlspecialchars($user["email"]); ?>"
                                required
                            >

                        </div>


                        <!-- BUTTONS -->

                        <div class="d-flex gap-2 flex-wrap">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="bi bi-check-lg me-1"></i>

                                Save Changes

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


<script src="./js/script.js"></script>


</body>

</html>