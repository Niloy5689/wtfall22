<?php
require_once dirname(__FILE__) . "/db.php";

$histories = get("SELECT * FROM history");
// echo '<pre>';
// var_dump($histories);
// echo '</pre>';
// exit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 3 | History</title>
    <style>
        ul {
            list-style-type: none;
            padding: 0;
        }

        ul>li {
            display: inline-block;
        }
    </style>
</head>

<body>
    <header>
        <h1>Page 3 | History</h1>
        <hr>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="conversion-rate.php">Conversion Rate</a></li>
                <li><a href="history.php">History</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Value</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($histories as $history) : ?>
                    <tr>
                        <td><?php echo $history['cat_name'] ?></td>
                        <td><?php echo $history['value'] ?></td>
                        <td><?php echo $history['result'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>