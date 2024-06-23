<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('0100111' === $password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: Page02.php");
                    exit;
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=B612:wght@400;700&display=swap");
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "B612", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
        }

        .login-container {
            width: 420px;
            background: rgba(255, 255, 255, -0.1); 
            border: 2px solid rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            color: #fff;
            border-radius: 10px;
            padding: 30px 40px;
        }

        h2 {
            font-size: 36px;
            text-align: center;
        }

        input[type="text"], input[type="password"] {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
            border-radius: 40px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none; 
            outline: none;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 40px;
            font-size: 16px;
            color: #fff;
            padding: 20px 45px 20px 20px;
        }

        button {
            width: 100px;
            height: 45px;
            background: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .back-video {
            left: 0;
            top: 0;
            position: absolute;
            z-index: -1;
        }

        @media(min-aspect-ratio: 16/9) {
            .back-video {
                width: 100%;
                height: auto;
            }
        }

        @media(max-aspect-ratio: 16/9) {
            .back-video {
                width: auto;
                height: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="whole">
        <video autoplay loop muted playsinline class="back-video">
            <source src="v.mp4" type="video/mp4">
        </video>
        <div class="login-container">
            <h2>Flying You Home</h2>
            <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="text" id="username" placeholder="Enter username" name="username" required>
                <input type="password" id="password" placeholder="Enter password" name="password" required>
                <button id="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>