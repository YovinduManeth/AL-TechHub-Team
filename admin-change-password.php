<?php

session_start();

if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: admin-login.html?error=unauthorized");
    exit();
}

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$message = "";
$message_type = "";

if (isset($_GET["success"])) {
    $message = "Your password has been changed successfully.";
    $message_type = "success";
}

if (isset($_GET["error"])) {

    if ($_GET["error"] === "current") {
        $message = "Your current password is incorrect.";
    } elseif ($_GET["error"] === "match") {
        $message = "New passwords do not match.";
    } elseif ($_GET["error"] === "length") {
        $message = "Password must contain at least 8 characters.";
    } elseif ($_GET["error"] === "empty") {
        $message = "Please fill in all required fields.";
    } else {
        $message = "Something went wrong. Please try again.";
    }

    $message_type = "danger";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change Password | A/L TechHub</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="css/style.css">

</head>

<body class="admin-page">

    <main class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-6">

                <div class="admin-upload-card">

                    <div class="admin-upload-header">

                        <div class="admin-upload-icon">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>

                        <div>
                            <h4 class="fw-bold mb-1">
                                Change Password
                            </h4>

                            <p class="mb-0">
                                Update your administrator password.
                            </p>
                        </div>

                    </div>

                    <div class="admin-upload-body">

                        <?php if ($message !== ""): ?>

                            <div class="alert alert-<?php echo $message_type; ?>">
                                <?php echo htmlspecialchars($message); ?>
                            </div>

                        <?php endif; ?>

                        <form
                            action="php/admin_change_password_process.php"
                            method="POST"
                        >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?php echo htmlspecialchars($_SESSION["csrf_token"]); ?>"
                            >

                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    Current Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    name="current_password"
                                    required
                                >

                            </div>

                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    New Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    name="new_password"
                                    minlength="8"
                                    required
                                >

                                <div class="form-text">
                                    Password must contain at least 8 characters.
                                </div>

                            </div>

                            <div class="mb-4">

                                <label class="form-label fw-bold">
                                    Confirm New Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    name="confirm_password"
                                    minlength="8"
                                    required
                                >

                            </div>

                            <button
                                type="submit"
                                class="btn btn-admin-primary w-100 py-3 fw-bold"
                            >

                                <i class="bi bi-key-fill me-2"></i>

                                Update Password

                            </button>

                        </form>

                        <div class="text-center mt-4">

                            <a
                                href="admin-upload.php"
                                class="text-decoration-none"
                            >
                                <i class="bi bi-arrow-left me-1"></i>
                                Back to Admin Dashboard
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</body>
</html>