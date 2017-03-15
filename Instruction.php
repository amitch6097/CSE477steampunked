<?php
/**
 * Created by PhpStorm.
 * User: wintonsea
 * Date: 2017/3/13
 * Time: 22:57
 */
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
<?php echo $view->Instruction_Present(); ?>
</body>
</html>
