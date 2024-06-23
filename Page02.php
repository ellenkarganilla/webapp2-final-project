<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=B612:wght@400;700&display=swap");
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "B612", sans-serif;
        }

        .posts-container {
            max-width: 600px;
            margin: 50px auto;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: #f0f0f0;
            border-radius: 10px;
            padding: 30px 40px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        li:hover {
            background-color: transparent;
        }

        .back-video {
            left: 0;
            top: 0;
            position: absolute;   
            z-index: -1;
            position: fixed;
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
    <div>
        <video autoplay loop muted playsinline class="back-video">
            <source src="v.mp4" type="video/mp4">
        </video>
        <div class="posts-container">
            <h1>Flights</h1> 
            <ul id="postLists"></ul>
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
                        $user_id = $_SESSION['user_id'];

                        $query = "SELECT * FROM `posts` WHERE userId = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $user_id]);

                        /*
                        * First approach using fetchAll and foreach loop
                        */
                        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($rows as $row) {
                            // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
                            echo '<li><a href="Page03.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                        }

                    /*
                    * Second approach using fetch and while loop
                    */
                    // while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
                    // echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                    // }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>
        
</html>