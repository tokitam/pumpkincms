<?php

if (@$this->page_data['flg_add_div']) {
    echo "<div class=\"twelve columns\">\n";
    echo "<h3>page module test</h3>\n";
    echo "<p>\n";
}

//echo $this->page_data['body'];
include($this->file);

if (@$this->page_data['flg_add_div']) {
    echo "</p>\n";
    echo "</div>\n";
}
