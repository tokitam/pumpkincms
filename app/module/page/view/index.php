<?php

if (@$this->page_data['flg_add_div']) {
    echo "<div class=\"twelve columns\">\n";
    echo "<h3>" . (isset($this->page_data['title']) ? $this->page_data['title'] : 'Title') . "</h3>\n";
    echo "<p>\n";
}

include($this->file);

if (@$this->page_data['flg_add_div']) {
    echo "</p>\n";
    echo "</div>\n";
}
