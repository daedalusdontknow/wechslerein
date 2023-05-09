<?php
/*
* Wechslerein
*
* (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

    $title = "Wechslerein - Settings";

    include '../objects.php';
    include '../../API/functions.php';

    $api = new API();
    $langAPI = new languageAPI();
    $itemAPI = new itemAPI();

    $api -> setBeta();
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="icon" href="/media/icon.png" type="image/x-icon">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/styles/main.css">
        <link rel="stylesheet" href="/styles/module.css">
    </head>

<?php printNavBarDesktop(); ?>

<body>

    <?php $api->getErrors(); ?>

    <div class="moduleContainer">
        <div class="headerContainer">
            <h1> <?php echo $langAPI -> getPhrase(".module.presets"); ?> </h1>
        </div>
        <a href="presets.php" class="button"> <?php echo $langAPI -> getPhrase(".module.presets.btn"); ?> </a>
    </div>

    <div class="moduleContainer">
        <div class="headerContainer">
            <h1> <?php echo $langAPI -> getPhrase(".module.add"); ?> </h1>
        </div>
        <form>
            <label for="language"> <?php echo $langAPI -> getPhrase(".module.add.item"); ?> </label><br>
            <select name="language" id="language">
                <?php
                $items = $itemAPI -> getItems();
                foreach ($items as $item) {
                    echo "<option value='" . $item . "'>" . $item . "</option>";
                }
                ?>
                <option value="custom">Custom</option>
            </select><br><br>
            <input type="submit" value="<?php echo $langAPI -> getPhrase(".save"); ?>">
        </form>
    </div>

    <div class="moduleContainer">
        <div class="headerContainer">
            <h1> <?php echo $langAPI -> getPhrase(".module.liveEditor"); ?> </h1>
        </div>
        <a href="live.php" class="button"> <?php echo $langAPI -> getPhrase(".module.liveEditor.btn"); ?> </a>
    </div>