<?php
require __DIR__ . '/lib/steampunked.inc.php';

$view = new Steampunked\StartView($steampunked);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Steampunked</title>
    <link href="style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php echo $view->Start_Present(); ?>
</body>
</html>
