<?php

session_start();

require_once "db.php";


// ==========================================
// REMOVE REMEMBER TOKEN FROM DATABASE
// ==========================================

if (isset($_SESSION["user_id"])) {

    $sql =
        "UPDATE users
         SET remember_token = NULL
         WHERE user_id = ?";

    $stmt =
        $conn->prepare($sql);

    $stmt->bind_param(
        "i",
        $_SESSION["user_id"]
    );

    $stmt->execute();

    $stmt->close();

}


// ==========================================
// DELETE REMEMBER ME COOKIE
// ==========================================

setcookie(
    "remember_token",
    "",
    [
        "expires" => time() - 3600,
        "path" => "/",
        "secure" => false,
        "httponly" => true,
        "samesite" => "Lax"
    ]
);


// ==========================================
// DESTROY SESSION
// ==========================================

session_unset();

session_destroy();


// ==========================================
// REDIRECT
// ==========================================

header("Location: ../login.html?logout=success");

exit();

?>