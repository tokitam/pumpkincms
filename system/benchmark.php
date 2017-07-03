<?php

class PC_Benchmark {
    static $enable = false;

    static $bench_data = array();

//  function __construct() {
//  }

    static function check($point) {
        if (self::$enable == false) {
            return;
        }

        $data = array('point' => $point, 'microtime' => microtime());
        array_push(self::$bench_data, $data);
    }

    static function dump() {
        if (self::$enable == false) {
            return;
        }

        $now = time();

        var_dump(self::$bench_data);
        $data = array_shift(self::$bench_data);
        $tmp2 = explode(' ', $data['microtime']);
        var_dump($tmp2);
        $t = intval($now - $tmp2[1]) + $tmp2[0];

        echo " t $t <br />\n";

        echo "-------- benchmark dump --------<br />\n";

        foreach (self::$bench_data as $val) {
            $tmp2 = explode(' ', $val['microtime']);
            $n = intval($now - $tmp2[1]) + $tmp2[0];

            echo "$n - $t <br />\n";
            if ($n == $t) {
                echo (0) . ':' . $val['point'] . "<br />\n";
            } else {
                echo ($n - $t) . ':' . $val['point'] . "<br />\n";
            }
            $t = $n;
        }
    }
}

