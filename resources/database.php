<?php
    /*
     * Wechslerein
     *
     * (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
     *
     * This source file is subject to the MIT license that is bundled
     * with this source code in the file LICENSE.
     */

    class SQL
    {
        public static function writeData($data): void
        {
            $db = new SQLite3(__DIR__ . "/DATA/data.db");
            $db->exec(
                "CREATE TABLE IF NOT EXISTS DATA (id INTEGER PRIMARY KEY, DATA TEXT, time DATETIME DEFAULT CURRENT_TIMESTAMP)"
            );
            $db->exec(
                'INSERT INTO DATA (`DATA`) VALUES (\'' . json_encode($data) . '\')'
            );
        }

        public static function readData($startTime, $endTime): mixed
        {
            $db = new SQLite3(__DIR__ . "/DATA/data.db");
            $db->exec(
                "CREATE TABLE IF NOT EXISTS DATA (id INTEGER PRIMARY KEY, DATA TEXT, time DATETIME DEFAULT CURRENT_TIMESTAMP)"
            );
            $result = $db->query(
                'SELECT * FROM DATA WHERE time BETWEEN \'' .
                $startTime .
                '\' AND \'' .
                $endTime .
                '\''
            );
            $data = [];
            while ($row = $result->fetchArray()) {
                $data[] = $row;
            }
            return $data;
        }
    }