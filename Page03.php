<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>

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

        .post-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: white;
            border-radius: 10px;
        }

        #postDetails {
            align-content: center;
            justify-content: center;
            padding: 50px;
            font-size: 20px;
            line-height: 30px;
        }

        .back-video {
            position: absolute;
            left: 0;
            top: 0;
            z-index: -1;
            width: 100%;
            height: auto;
        }

        @media (max-aspect-ratio: 16/9) {
            .back-video {
                width: auto;
                height: 100%;
            }
        }
    </style>
</head>

<body>
    <div>
        <video autoplay loop muted playsinline class="back-video">
            <source src="v.mp4" type="video/mp4">
        </video>
        <div class="post-container">
            <h1>Travel Info</h1> 
            <div id="postDetails"></div>
            <?php

            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: Page01.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        $query = "SELECT * FROM `posts` WHERE id = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $id]);

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3>Title: ' . $post['title'] . '</h3>';
                            echo '<p>Body: ' . $post['body'] . '</p>';
                        } else {
                            echo "No post found with ID $id!";
                        }
                    } else {
                        echo "No post ID provided!";
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>
</body>

</html>