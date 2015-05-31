<?php

namespace App\Helpers;

class LogHelper {

    public static function dumpShallowObject($collection) {
        $array = $collection->toArray();
        foreach (array_keys($array) as $topKey) {
            $topValue = $array[$topKey];
            if (is_array($topValue)) {
                $array[$topKey] = null;
                //echo "removing key $topKey\n";
            }
        }
        return $array;
    }

    public static function dumpShallowArray($collection) {
        $array = $collection->toArray();
        foreach (array_keys($array) as $topKey) {
            $topValue = $array[$topKey];
            if (is_array($topValue)) {
                foreach (array_keys($topValue) as $key) {
                    $value = $topValue[$key];
                    if (is_array($value)) {
                        //echo "removing key $topKey.$key\n";
                        $topValue[$key] = null;
                    }
                }
            }
        }
        return ['count' => count($array), 'array' => $array];
    }

}
