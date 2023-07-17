<?php
    /*
     * Wechslerein
     *
     * (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
     *
     * This source file is subject to the MIT license that is bundled
     * with this source code in the file LICENSE.
     */
    class API
    {
        public static function getVersion(): string
        {
            return "B0.1.0";
        }

        public static function configExists(): bool
        {
            return file_exists(__DIR__ . "/DATA/config.json");
        }

        public static function getConfig(): array
        {
            return json_decode(
                file_get_contents(__DIR__ . "/DATA/config.json"),
                true
            );
        }

        public static function getErrors(): void
        {
            if (!self::configExists()) {
                printAlert("error", languageAPI::getPhrase(".error.config"));
            }

            if (isset($_GET["settings"])) {
                if ($_GET["settings"] == "success") {
                    printAlert(
                        "success",
                        languageAPI::getPhrase(".settings.success")
                    );
                }
                if ($_GET["settings"] == "failed") {
                    printAlert(
                        "failed",
                        languageAPI::getPhrase(".settings.failed")
                    );
                }
            }

            if (isset($_GET["beta"])) {
                printAlert("failed", languageAPI::getPhrase(".beta"));
            }
        }

        public static function setBeta(): void
        {
            if (!isset($_GET["beta"])) {
                header("Location: ?beta");
                exit();
            }
        }

        public static function getData(): array
        {
            $data = file_get_contents(__DIR__ . "/DATA/config.json");
            $data = explode(";", $data)[1];
            return json_decode($data, true);
        }

        public static function getDataLast($minutes): void
        {
            $data = file_get_contents(__DIR__ . "/DATA/config.json");
            $data = explode(";", $data)[1];

            include_once __DIR__ . "/database.php";
            $dbData = SQL::readData(
                date("Y-m-d H:i:s", strtotime("-" . $minutes . " minutes")),
                date("Y-m-d H:i:s")
            );

            $data = array_merge(json_decode($data, true), $dbData);

            echo json_encode($data, true);
        }
    }

    class languageAPI
    {
        static function getLanguages(): array
        {
            return array_map(
                function ($file) {
                    return json_decode(
                        file_get_contents(
                            __DIR__ . "/../assets/lang-packs/" . $file
                        ),
                        true
                    )["name"];
                },
                array_filter(scandir(__DIR__ . "/../assets/lang-packs"), function (
                    $file
                ) {
                    return $file != "." && $file != "..";
                })
            );
        }

        static function getLanguage(): string
        {
            if (API::configExists()) {
                $config = API::getConfig();
                return $config["language"] ?? "en";
            } else {
                return "en";
            }
        }

        static function loadLanguage($language): array
        {
            return json_decode(
                file_get_contents(
                    __DIR__ . "/../assets/lang-packs/" . $language . ".json"
                ),true
            );
        }

        static function getPhrase($phraseID)
        {
            if (!isset($_COOKIE["lang"])) {
                $lang = languageAPI::getLanguage();
                setcookie("lang", $lang, time() + 120, "/");
            }

            $lang = $_COOKIE["lang"];
            $phraseID = $lang . $phraseID;

            return self::loadLanguage($lang)[$phraseID];
        }
    }

    class itemAPI
    {

    }