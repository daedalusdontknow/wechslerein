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

        public function getVersion() : string {
            return "B0.0.3";
        }

        public function configExists() : bool {
            return file_exists(__DIR__ . "/../DATA/config.json");
        }

        public function getConfig() : array {
            return json_decode(file_get_contents(__DIR__ . "/../DATA/config.json"), true);
        }

        public function getErrors(): void
        {
            $langAPI = new languageAPI();

            if(!$this->configExists()) {
                printAlert("error", $langAPI -> getPhrase(".error.config"));
            }

            if(isset($_GET["settings"])) {
                if($_GET["settings"] == "success") {
                    printAlert("success", $langAPI->getPhrase(".settings.success"));
                }
                if($_GET["settings"] == "failed") {
                    printAlert("failed", $langAPI -> getPhrase(".settings.failed"));
                }
            }

            if(isset($_GET["beta"])) {
                printAlert("failed", $langAPI -> getPhrase(".beta"));
            }
        }

        public function setBeta() : void
        {
            if (!isset($_GET["beta"])) {
                header("Location: ?beta");
                exit();
            }
        }

        function getData() : array {
            $data = file_get_contents(__DIR__ . "/../DATA/data.json");
            $data = explode(";", $data)[1];
            return json_decode($data, true);
        }

        function getDataLast($minutes): void
        {
            $data = file_get_contents(__DIR__ . "/../DATA/data.json");
            $data = explode(";", $data)[1];

            include_once __DIR__ . "/database.php";
            $sql = new SQL();
            $dbData = $sql->readData(date("Y-m-d H:i:s", strtotime("-" . $minutes . " minutes")), date("Y-m-d H:i:s"));

            $data = array_merge(json_decode($data, true), $dbData);

            echo json_encode($data, true);
        }
    }

    class languageAPI {

        public function getLanguages() : array {
            return array_map(function($file) {
                return json_decode(file_get_contents(__DIR__ . "/../LANGUAGE/" . $file), true)["name"];
            }, array_filter(scandir(__DIR__ . "/../LANGUAGE"), function($file) {
                return $file != "." && $file != "..";
            }));
        }

        public function getLanguage() : string {
            $api = new API();
            if ($api -> configExists()) {
                $config = $api->getConfig();
                return $config["language"] ?? "en";
            } else {
                return "en";
            }
        }

        public function loadLanguage($language) : array {
            return json_decode(file_get_contents(__DIR__ . "/../LANGUAGE/" . $language . ".json"), true);
        }

        public function getPhrase($phraseID) : string {

            if (!isset($_COOKIE["lang"])) {
                $langAPI = new languageAPI();
                $lang = $langAPI->getLanguage();
                setcookie("lang", $lang, time() + 120, "/");
            }

            $lang = $_COOKIE["lang"];
            $phraseID = $lang . $phraseID;

            return $this->loadLanguage($lang)[$phraseID];
        }
    }

    class itemAPI {
        public function getItems() : array {
            $data = file_get_contents(__DIR__ . "/../DATA/data.json");
            $data = explode(";", $data)[1];
            $data = json_decode($data, true);

            $items = [];
            foreach ($data["Common"]["PV"] as $key => $value) {
                if (str_contains($key, "pv")) {
                    $items[] = $key;
                }
            }
            return $items;
        }
    }