<?php

namespace classes;

class ArrayHelper {
    public function arrayToString($array, $separator) : string {
        if (is_array($array)) return implode($separator, $array);
        else return $array;
    }

    public function stringToArray($string, $separator) : array {
        if (is_string($string)) {
            return explode($separator, $string);
        } else {
            return [];
        }
    }

    public function arrayGet(array $array, string $key, $default = null) {
        return $array[$key] ?? $default;
    }

    public function arrayDebug($array) {
        echo '<pre>';
        var_dump($array);
        echo '</pre>';
    }
}