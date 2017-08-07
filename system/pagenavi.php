<?php

class PC_PageNavi {
    var $total;
    var $offset;
    var $limit;
    var $navi_html;
    var $option;
    var $link_option;

    function __construct($total, $offset, $limit, $option=null) {
        $this->total = intval($total);
        $this->offset = intval($offset);
        $this->limit = intval($limit);
        $this->navi_html = '';
        $this->option = $option;

        if ($this->total <= $this->offset) {
            $this->offset = 0;
        }
        if ($this->total <= $this->limit) {
            $this->offset = 0;
        }
        if (@$option['link_option']) {
            $this->link_option = '&' . $option['link_option'];
        } else {
            $this->link_option = '';
        }

    }

    function need_prev_link()
    {
        if ($this->offset == 0) {
            return false;
        } else {
            return true;
        }
    }

    function need_next_link()
    {
        if ($this->total <= $this->offset + $this->limit) {
            return false;
        } else {
            return true;
        }
    }

    function get_prev()
    {
        if ($this->offset - $this->limit < 0) {
            return 0;
        } else {
            return $this->offset - $this->limit;
        }
    }

    function get_next()
    {
        if ($this->total < $this->offset + $this->limit) {
            return $this->total - $this->limit;
        } else {
            return $this->offset + $this->limit;
        }
    }

    function get_top()
    {
        return 0;
    }

    function get_last()
    {
        return $this->total - $this->limit;
    }


    function get_page_list()
    {
        if ($this->total <= $this->limit) {
            return array();
        }

        $num_of_page = intval($this->total / $this->limit);
        if ($this->total % $this->limit) {
            $num_of_page++;
        }
        $now_page = intval($this->offset / $this->limit) + 1;
        $list = array();

        for ($i=1; $i <= $num_of_page; $i++) {
            if ($i == $now_page || $i == 1 || $i == $num_of_page || ($i < $now_page + 4 && $now_page - 4 < $i)) {
                if ($i == $now_page) {
                    array_push($list, array('page' => $i, 'value' => ($this->limit * ($i - 1))));
                    continue;
                }

                if ($i == $num_of_page && $now_page < $num_of_page - 4) {
                    array_push($list, array('page' => $i, 'value' => -1));
                }
                array_push($list, array('page' => $i, 'value' => ($this->limit * ($i - 1))));
                if ($i == 1 & 4 + 1 < $now_page) {
                    array_push($list, array('page' => $i, 'value' => -1));
                }

            }

        }

        return $list;
    }

    function get_page_link() {
        if ($this->navi_html != '') {
            return $this->navi_html;
        }
        if ($this->total <= $this->limit) {
            $this->navi_html = '';
            return $this->navi_html;
        }

        if (preg_match('/^[ud]_[_0-9A-Za-z]+$/', @$_GET['sort'])) {
            $sort = '&sort=' . $_GET['sort'];
        } else {
            $sort = '';
        }
		
		if (!empty($this->option['class'])) {
			$class = ' ' . $this->option['class'];
		} else {
			$class = '';
		}

        $html = '<ul class="pagination'. $class . '">' . "\n";

        if ($this->need_prev_link()) {
            $html .= sprintf('<li><a href="?offset=%d&limit=%d%s%s">&lt;</a></li> ' . "\n", $this->get_prev(), $this->limit, $this->link_option, $sort);
        } else {
            $html .= sprintf('<li class="disabled"><a>&lt;</a></li> ' . "\n", $this->get_prev(), $this->limit, $sort);
        }

        $list = $this->get_page_list();

        foreach ($list as $key => $item) {
            $offset = $item['value'];
            $page = $item['page'];

            if ($offset == -1) {
                $html .= '<li><a>...</a></li>' . "\n";
                continue;
            }

            if ($offset == $this->offset) {
                $html .= sprintf('<li class="active"><a>%d</a></li> ' . "\n", $page);
            } else {
                $html .= sprintf('<li><a href="?offset=%d&limit=%d%s%s">%d</a></li> ' . "\n", $offset, $this->limit, $this->link_option, $sort, $page);
            }
        }

        if ($this->need_next_link()) {
            $html .= sprintf('<li><a href="?offset=%d&limit=%d%s%s">&gt;</a></li> ' . "\n", $this->get_next(), $this->limit, $this->link_option, $sort);
        } else {
            $html .= sprintf('<li class="disabled"><a>&gt;</a></li> ' . "\n", $this->get_next(), $this->limit, $sort);
        }

        $html .= '</ul>' . "\n";

        $this->navi_html = $html;

        return $html;
    }
}
