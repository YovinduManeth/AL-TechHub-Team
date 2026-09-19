<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html?error=login_required");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

$name = "";
$email = "";
$subject = "";
$message = "";


// =================================
// Database Connection
// =================================

$conn = new mysqli("localhost", "root", "", "al_techhub_team");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


// =================================
// Handle Contact Form Submission
// =================================

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");


    // =================================
    // Validate Required Fields
    // =================================

    if ($name === "" || $email === "" || $subject === "" || $message === "") {

        $error_message = "Please fill in all fields.";

    }

    // =================================
    // Validate Email
    // =================================

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error_message = "Please enter a valid email address.";

    }

    else {

        // =================================
        // Insert Message into Database
        // =================================

        $stmt = $conn->prepare(
    "INSERT INTO contact_messages
    (name, email, subject, message)
    VALUES (?, ?, ?, ?)"
);

        // Check if SQL statement was prepared correctly

        if (!$stmt) {

            $error_message = "Database error: " . $conn->error;

        }

        else {

            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $subject,
                $message
            );

            // =================================
            // Execute Insert
            // =================================

            if ($stmt->execute()) {

                $success_message = "Your message has been sent successfully.";

                // Clear the form after successful submission
                $name = "";
                $email = "";
                $subject = "";
                $message = "";

            }

            else {

                $error_message = "Unable to send your message. Please try again.";

            }


            $stmt->close();
        }
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

    <title>Contact Us | A/L TechHub</title>


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


<body class="contact-page">


    <!-- =================================
         Navigation Bar
    ================================== -->

    <nav
        class="navbar navbar-expand-lg navbar-light bg-white sticky-top dashboard-navbar"
    >

        <div class="container">


            <!-- Brand -->

            <a
                class="navbar-brand fw-bold dashboard-brand"
                href="index.html"
            >

                <i class="bi bi-mortarboard-fill me-1"></i>

                A/L TechHub

            </a>


            <!-- Mobile Toggle -->

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#contactNavbar"
                aria-controls="contactNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >

                <span class="navbar-toggler-icon"></span>

            </button>


            <!-- Navigation -->

            <div
                class="collapse navbar-collapse"
                id="contactNavbar"
            >

                <ul class="navbar-nav me-auto ms-lg-4">


                    <!-- Home -->

                    <li class="nav-item">

                        <a
                            class="nav-link dashboard-nav-link"
                            href="index.html"
                        >

                            <i class="bi bi-house me-1"></i>

                            Home

                        </a>

                    </li>


                    <!-- Dashboard -->

                    <li class="nav-item">

                        <a
                            class="nav-link dashboard-nav-link"
                            href="dashboard.php"
                        >

                            <i class="bi bi-grid-1x2-fill me-1"></i>

                            Dashboard

                        </a>

                    </li>


                    <!-- Contact -->

                    <li class="nav-item">

                        <a
                            class="nav-link dashboard-nav-link active"
                            href="contact.php"
                        >

                            <i class="bi bi-envelope me-1"></i>

                            Contact Us

                        </a>

                    </li>

                </ul>


                <div class="d-flex align-items-center gap-3">


                    <!-- Username -->

                    <a
                        href="profile.php"
                        class="dashboard-user text-decoration-none"
                    >

                        <i class="bi bi-person-circle me-1"></i>

                        <?php echo htmlspecialchars($username); ?>

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
                        href="login.php"
                        class="btn btn-outline-primary btn-sm px-3"
                    >

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout

                    </a>

                </div>

            </div>

        </div>

    </nav>



    <!-- =================================
         Contact Hero
    ================================== -->

    <section class="contact-hero">

        <div class="container">

            <div class="text-center">

                <span class="contact-label">
                    GET IN TOUCH
                </span>

                <h1>
                    Contact <span>Us</span>
                </h1>

                <p>
                    Have a question about A/L TechHub?
                    We are here to help you with your learning journey.
                </p>

            </div>

        </div>

    </section>



    <!-- =================================
         Contact Section
    ================================== -->

    <main class="container py-5">

        <div class="row g-4">


            <!-- =================================
                 Contact Information
            ================================== -->

            <div class="col-lg-5">

                <div class="contact-info-card h-100">

                    <span class="contact-section-label">
                        CONTACT INFORMATION
                    </span>

                    <h3>
                        We are here to help.
                    </h3>

                    <p class="contact-info-text">

                        If you have questions, suggestions, or need
                        assistance with the A/L TechHub learning platform,
                        feel free to contact us.

                    </p>


                    <!-- Email -->

                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="bi bi-envelope-fill"></i>

                        </div>

                        <div>

                            <small>Email</small>

                            <strong>
                                support@altechhub.com
                            </strong>

                        </div>

                    </div>


                    <!-- Phone -->

                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="bi bi-telephone-fill"></i>

                        </div>

                        <div>

                            <small>Phone</small>

                            <strong>
                                +94 11 234 5678
                            </strong>

                        </div>

                    </div>


                    <!-- Location -->

                    <div class="contact-info-item">

                        <div class="contact-icon">

                            <i class="bi bi-geo-alt-fill"></i>

                        </div>

                        <div>

                            <small>Location</small>

                            <strong>
                                Sri Lanka
                            </strong>

                        </div>

                    </div>


                    <!-- Support -->

                    <div class="contact-support-box">

                        <i class="bi bi-headset"></i>

                        <div>

                            <strong>
                                Student Support
                            </strong>

                            <p>

                                We aim to provide a better learning
                                experience for every Technology Stream student.

                            </p>

                        </div>

                    </div>

                </div>

            </div>



            <!-- =================================
                 Contact Form
            ================================== -->

            <div class="col-lg-7">

                <div class="contact-form-card">


                    <!-- Form Heading -->

                    <div class="mb-4">

                        <span class="contact-section-label">
                            SEND A MESSAGE
                        </span>

                        <h3>
                            How can we help?
                        </h3>

                        <p class="text-muted">
                            Fill out the form below and send us your message.
                        </p>

                    </div>



                    <!-- =================================
                         SUCCESS MESSAGE
                    ================================== -->

                    <?php if ($success_message !== ""): ?>

                        <div
                            class="alert alert-success alert-dismissible fade show"
                            role="alert"
                        >

                            <i class="bi bi-check-circle-fill me-2"></i>

                            <strong>Success!</strong>

                            <?php
                            echo htmlspecialchars($success_message);
                            ?>


                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                            ></button>

                        </div>

                    <?php endif; ?>



                    <!-- =================================
                         ERROR MESSAGE
                    ================================== -->

                    <?php if ($error_message !== ""): ?>

                        <div
                            class="alert alert-danger alert-dismissible fade show"
                            role="alert"
                        >

                            <i class="bi bi-exclamation-circle-fill me-2"></i>

                            <strong>Error!</strong>

                            <?php
                            echo htmlspecialchars($error_message);
                            ?>


                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                            ></button>

                        </div>

                    <?php endif; ?>



                    <!-- =================================
                         Contact Form
                    ================================== -->

                    <form
                        method="POST"
                        action="contact.php"
                    >


                        <!-- Name -->

                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label fw-semibold"
                            >

                                Full Name

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="Enter your full name"
                                value="<?php echo htmlspecialchars($name); ?>"
                                required
                            >

                        </div>



                        <!-- Email -->

                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label fw-semibold"
                            >

                                Email Address

                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Enter your email address"
                                value="<?php echo htmlspecialchars($email); ?>"
                                required
                            >

                        </div>



                        <!-- Subject -->

                        <div class="mb-3">

                            <label
                                for="subject"
                                class="form-label fw-semibold"
                            >

                                Subject

                            </label>

                            <select
                                class="form-select"
                                id="subject"
                                name="subject"
                                required
                            >

                                <option
                                    value=""
                                    disabled
                                    <?php
                                    echo $subject === ""
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Select a subject
                                </option>


                                <option
                                    value="Technical Support"
                                    <?php
                                    echo $subject === "Technical Support"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Technical Support
                                </option>


                                <option
                                    value="Account Problem"
                                    <?php
                                    echo $subject === "Account Problem"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Account Problem
                                </option>


                                <option
                                    value="Learning Resources"
                                    <?php
                                    echo $subject === "Learning Resources"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Learning Resources
                                </option>


                                <option
                                    value="Data Saver Mode"
                                    <?php
                                    echo $subject === "Data Saver Mode"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Data Saver Mode
                                </option>


                                <option
                                    value="General Inquiry"
                                    <?php
                                    echo $subject === "General Inquiry"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    General Inquiry
                                </option>


                                <option
                                    value="Feedback"
                                    <?php
                                    echo $subject === "Feedback"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Feedback
                                </option>

                            </select>

                        </div>



                        <!-- Message -->

                        <div class="mb-4">

                            <label
                                for="message"
                                class="form-label fw-semibold"
                            >

                                Message

                            </label>

                            <textarea
                                class="form-control"
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="Write your message here..."
                                required
                            ><?php echo htmlspecialchars($message); ?></textarea>

                        </div>



                        <!-- Submit Button -->

                        <button
                            type="submit"
                            class="btn btn-contact w-100"
                        >

                            <i class="bi bi-send-fill me-2"></i>

                            Send Message

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </main>



    <!-- =================================
         Footer
    ================================== -->

    <footer class="home-footer py-4">

        <div class="container text-center">

            <p class="mb-0 small">

                © 2026 A/L TechHub. All rights reserved.

            </p>

        </div>

    </footer>



    <!-- Bootstrap JavaScript -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    ></script>

</body>

</html>