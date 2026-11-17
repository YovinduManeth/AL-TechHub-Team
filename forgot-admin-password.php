<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Admin Password - A/L TechHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="card shadow p-4" style="max-width: 450px; width: 100%;">

        <h3 class="text-center mb-3">Forgot Password?</h3>

        <p class="text-center text-muted">
            Enter your registered administrator email address.
            We will help you reset your password.
        </p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                Something went wrong. Please try again.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                If the email belongs to an administrator account,
                password reset instructions will be sent.
            </div>
        <?php endif; ?>

        <form action="php/admin_forgot_password_process.php" method="POST">

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>

                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your registered email"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Send Reset Link
            