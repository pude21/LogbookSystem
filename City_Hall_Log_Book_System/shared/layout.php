<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge, chrome=1.0, safari">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/image/city_logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/app.css" />
    <link rel="stylesheet" href="../assets/css/w3.css">
    <link rel="stylesheet" href="../assets/css/loader.css">
    <?php echo $styles ?? "" ?>
    <title>
        <?php echo isset($title) ? "Log Book | $title" : "" ?>
    </title>
</head>

<body>

    <div class="loader" id="loadingModal">
        <div class="dot dot-1"></div>
        <div class="dot dot-2"></div>
        <div class="dot dot-3"></div>
        <div class="dot dot-4"></div>
        <div class="dot dot-5"></div>
    </div>

    <?php echo $navbar ?? "" ?>

    <!-- Content of the page -->
    <?php echo $content ?? "" ?>

    <!-- JS -->
    <script type="module" src="../assets/js/app.js"></script>
    <script src="../assets/js/loader.js"></script>

    <?php echo $scripts ?? "" ?>
</body>

</html>