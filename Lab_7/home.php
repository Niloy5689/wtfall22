<?php
require_once dirname(__FILE__) . "/db.php";

$categories = get("SELECT * FROM category");
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// exit;

if (isset($_POST['calculate'])) {
    $category = sanitize($_POST['category']);
    $value = sanitize($_POST['value']);
    $result = sanitize($_POST['result']);

    $category_err = "";
    $value_err = "";
    $result_err = "";

    $has_err = false;
    $is_created = 0;

    if (empty($category)) {
        $category_err = "Category can't be empty";
        $has_err = true;
    }

    if (empty($value)) {
        $value_err = "value can't be empty";
        $has_err = true;
    } elseif (!is_numeric($value)) {
        $value = "value must be numeric";
    }

    if (empty($result)) {
        $result_err = "result can't be empty";
        $has_err = true;
    } elseif (!is_numeric($result)) {
        $unit = "result must be numeric";
    }

    if (!$has_err) {
        require_once dirname(__FILE__) . "/db.php";

        $category_name = get("SELECT name from category WHERE id = :id", [
            ":id" => $category,
        ])[0]["name"];
        // var_dump($category_name);
        $is_created = execute("INSERT INTO history (cat_name, value, result) VALUES (:cat_name, :value, :result)", [
            ":cat_name" => $category_name,
            ":value" => $value,
            ":result" => $result,
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
    <title>Page 1 | Home</title>
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
        <h1>Page 1 | Home</h1>
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
        <form action="" method="post" id="currency-calculate">
            <label>Select Category: </label>
            <select name="category">
                <option value="">Select a value</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category["id"]; ?>" data-unit="<?php echo $category["unit"]; ?>" data-rate="<?php echo $category["rate"]; ?>"><?php echo $category["name"]; ?></option>
                <?php endforeach; ?>
            </select>
            <span><?php echo isset($category_err) ? $category_err : ""; ?></span>
            <br>

            <label for="value">Value: </label>
            <input id="value" type="text" name="value">
            <span><?php echo isset($value_err) ? $value_err : ""; ?></span>
            <br>

            <label for="result">Result: </label>
            <input id="result" type="text" name="result">
            <span><?php echo isset($result_err) ? $result_err : ""; ?></span>
            <br>

            <input type="submit" name="calculate">
        </form>
    </main>

    <script>
        const form = document.forms['currency-calculate'];

        form.addEventListener('input', function(event) {
            const unit = form['category'].selectedOptions[0].dataset.unit;
            const rate = form['category'].selectedOptions[0].dataset.rate;
            const _value = form['value'];
            const result = form['result'];

            if (unit && rate) {
                if (event.target.name === 'value') {
                    let r = rate / unit;
                    console.log(r);
                    result.value = r * Number(event.target.value.trim());
                } else {
                    let r = unit / rate;
                    console.log(r);
                    _value.value = r * Number(event.target.value.trim());
                }
            }
        });
    </script>

</body>

</html>