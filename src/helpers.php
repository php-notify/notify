<?php

if (!function_exists('array_column')) {
    /**
     * @see https://www.php.net/manual/fr/function.array-column.php
     *
     * @param array $input
     * @param mixed $columnKey
     * @param mixed $indexKey
     *
     * @return array
     */
    function array_column(array $input, $columnKey, $indexKey = null)
    {
        $output = array();

        foreach ($input as $row) {
            $key    = $value = null;
            $keySet = $valueSet = false;

            if ($indexKey !== null && array_key_exists($indexKey, $row)) {
                $keySet = true;
                $key    = (string)$row[$indexKey];
            }

            if ($columnKey === null) {
                $valueSet = true;
                $value    = $row;
            } elseif (is_array($row) && array_key_exists($columnKey, $row)) {
                $valueSet = true;
                $value    = $row[$columnKey];
            }

            if (!$valueSet) {
                continue;
            }

            if ($keySet) {
                $output[$key] = $value;
            } else {
                $output[] = $value;
            }
        }

        return $output;
    }
}
