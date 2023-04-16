<?php
require_once __DIR__ . '/vendor/autoload.php';

use Classes\CurrencyConverter;
use Classes\Services\CurrencyConversionRates;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css"
          integrity="sha384-T8Gydk20uQc5Hj1xFAkJb5H9OIpyDjzJLfGm/s73yjL9v7aJc0S7l2" crossorigin="anonymous"
</head>
<body class="container">
<div class="row" style="margin-bottom: 20px; margin-top: 20px;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Currency Conversion</h3>
            </div>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
    <form action="index.php" method="post">
        <label for="value">Value:</label>
        <input type="number" step="0.01" name="value" id="value" required>

        <label for="currency">Currency:</label>
        <input type="text" name="currency" id="currency" required>

        <input type="submit" name="submit" value="Convert">
    </form>
</div>
<div class="row d-flex justify-content-center">
    <pre class="border bg-light p-2 rounded">
        <code id="json-container">
        <?php
        if (isset($_POST['submit'])) {
            $value = floatval($_POST['value']);
            $currency = htmlspecialchars($_POST['currency']);

            $currencyConverter = new CurrencyConverter(CurrencyConversionRates::get());
            $response = $currencyConverter->convert($value, $currency);

            echo $response;
        }
        ?>
        </code>
    </pre>
</div>
</body>
</html>
