<?php
    /*
    * Wechslerein
    *
    * (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
    *
    * This source file is subject to the MIT license that is bundled
    * with this source code in the file LICENSE.
    */

    function getGraphPoints($type, $range): string
    {
        include_once __DIR__ . "/functions.php";
        $api = new API();

        $data = $api->getDataLast($range);

        switch ($type) {
            case "BATTSOC": {
                $data = $data["Common"]["BATT"]["SOC"];
                break;
            }
        }
        return $data;
    }


if (isset($_GET['getGraphics'])) {
    if ($_GET['getGraphics'] == "points") {
        if (isset($_GET['type']) && isset($_GET['range'])) {
            getGraphPoints($_GET['type'], $_GET['range']);
        } else {
            printAlert("failed", "Missing parameters");
        }
    }
}