<?php
/*
 * Wechslerein
 *
 * (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
*/

$title = "Wechslerein";

include_once '../../assets/objects.php';
include_once '../../resources/functions.php';
?>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="icon" href="/assets/media/icon.png" type="image/x-icon">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/assets/style/main.css">
    </head>


    <?php printNavBarDesktop(); ?>

    <body>
        <?php API::getErrors(); ?>
    </body>
</html>