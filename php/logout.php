<?php

session_start();

require_once "db.php";

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


session_unset();

session_destroy();


header("Location: ../login.html?logout=success");

exit();

?>