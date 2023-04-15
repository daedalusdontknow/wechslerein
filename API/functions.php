<?php
/*
* Wechslerein
*
* (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

    class API {
        public function configExists() : bool {
            return file_exists(__DIR__ . "/../DATA/config.json");
        }

        public function getConfig() : array {
            return json_decode(file_get_contents(__DIR__ . "/../DATA/config.json"), true);
        }

    }