<?php
if (isset($_POST["add-category"])) {
    $category = sanitize($_POST["category"]);
    $unit = sanitize($_POST["unit"]);
    $rate = sanitize($_POST["rate"]);

    $category_err = "";
    $unit_err = "";
    $rate_err = "";

    $has_err = false;
    $is_created = 0;

    if (empty($category)) {
        $category_err = "Category can't be empty";
        $has_err = true;
    }

    if (empty($unit)) {
        $unit_err = "Unit can't be empty";
        $has_err = true;
    } elseif (!is_numeric($unit)) {
        $unit = "Unit must be numeric";
    }

    if (empty($rate)) {
        $rate_err = "Rate can't be empty";
        $has_err = true;
    } elseif (!is_numeric($rate)) {
        $unit = "Rate must be numeric";
    }

    if (!$has_err) {
        require_once dirname(__FILE__) . "/db.php";

        $is_created = execute("INSERT INTO category (name, unit, rate) VALUES (:name, :unit, :rate)", [
            ":name" => $category,
            ":unit" => $unit,
            ":rate" => $rate,
        ]);
    }
}

function sanitize($var)
{
    return htmlspecialchars(trim($var));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 2 | Conversion Rate</title>
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
        <h1>Page 2 | Conversion Rate</h1>
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
        <?php if (isset($is_created) && $is_created > 0) : ?>
            <h3>Successfully created</h3>
        <?php endif; ?>
        <form action="" method="post">
            <label for="category">Category: </label>
            <input id="category" type="text" name="category">
            <span><?php echo isset($category_err) ? $category_err : ""; ?></span>
            <br>

            <label for="unit">Unit: </label>
            <input id="unit" type="text" name="unit">
            <span><?php echo isset($unit_err) ? $unit_err : ""; ?></span>
            <br>

            <label for="rate">Rate: </label>
            <input id="rate" type="text" name="rate">
            <span><?php echo isset($rate_err) ? $rate_err : ""; ?></span>
            <br>

            <input type="submit" name="add-category">
        </form>

    </main>
</body>

</html>