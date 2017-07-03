<?php

$list = $this->_data['feed'];

echo "<table class='table table-striped table-hover block_info_title'>\n<tbody>\n";

$i = 0;
foreach ($list as $item) {
    $title = $item['title'];
    echo "<tr>\n";
    printf("<td style='text-align: left;'><a href='%s'>%s</a></td><td>%s</td>\n",
        $item['url'],
        htmlspecialchars(PC_Util::mb_truncate($title)),
        strftime('%Y/%m/%d %H:%M', $item['time'])
        );
    echo "</tr>\n";
    $i++;
    if (7 <= $i) {
        break;
    }
}

echo "</tbody></table>\n";
