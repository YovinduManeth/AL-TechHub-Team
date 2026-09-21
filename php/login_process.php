<?php

session_start();

require_once "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../login.html");
    exit();

}


$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";


if (empty($username) || empty($password)) {

    header("Location: ../login.html?error=empty");
    exit();

}


$sql = "SELECT user_id, full_name, username, email, password, role
        FROM users
        WHERE username = ? OR email = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ss",
    $username,
    $username
);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows === 0) {

    $stmt->close();

    header("Location: ../login.html?error=invalid");
    exit();

}


$user = $result->fetch_assoc();

$stmt->close();

if (!password_verify($password, $user["password"])) {

    header("Location: ../login.html?error=invalid");
    exit();

}

session_regenerate_id(true);


if (isset($_POST["remember_me"])) {

    $remember_token = bin2hex(random_bytes(32));

    $update_sql =
        "UPDATE users
         SET remember_token = ?
         WHERE user_id = ?";

    $update_stmt = $conn->prepare($update_sql);

    if (!$update_stmt) {
        die("Remember Me database error: " . $conn->error);
    }

    $update_stmt->bind_param(
        "si",
        $remember_token,
        $user["user_id"]
    );

    if (!$update_stmt->execute()) {
        die("Remember Me update error: " . $update_stmt->error);
    }

    $update_stmt->close();

    setcookie(
        "remember_token",
        $remember_token,
        [
            "expires" => time() + (30 * 24 * 60 * 60),
            "path" => "/",
            "secure" => false,
            "httponly" => true,
            "samesite" => "Lax"
        ]
    );
}

$_SESSION["user_id"] = $user["user_id"];
$_SESSION["full_name"] = $user["full_name"];
$_SESSION["username"] = $user["username"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];


if ($user["role"] === "admin") {

    header("Location: ../admin-upload.php");

} else {

    header("Location: ../dashboard.php");

}

exit();

?>
