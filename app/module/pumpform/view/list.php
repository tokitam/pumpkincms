<?php

$form_config = $GLOBALS['pumpform_config'][$this->_module][$this->_table];
$form = $form_config['column'];

?>
<div class="twelve columns">
<h3><?php echo $form_config['title'] ?></h3>
<p>


<?php

$list = $this->_data['list'];
$pn = $this->_data['pagenavi'];

$form = $GLOBALS['pumpform_config'][$this->_module][$this->_table]['column'];

$url = PC_Config::url();
$css_url = SiteInfo::get_css_url();
$module_url = PC_Util::get_module_url();
$url_option = '';
if (@$form_config['1n_link_id']) {
    $url_option = '?' . $form_config['1n_link_id'] . '=' . @$_GET[$form_config['1n_link_id']];
}

$add_url = '';
if (!empty($form_config['add_path'])) {
    if (PC_Util::is_url($form_config['add_path'])) {
    	$add_url = $form_config['add_path'];
    } else {
    	$add_url = PC_Config::url() . $form_config['add_path'];
    }
} else if (empty($form_config['do_not_show_insert_button']) || $form_config['do_not_show_insert_button'] == false) {
	$add_url = $module_url . "/add/" . $url_option;
}

        $html = '';

    if (!empty($add_url) && empty($form_config['do_not_show_insert_button'])) {
        $html .= "<a href='" . $add_url . "' class='btn btn-default'>" . _MD_PUMPFORM_ADD . "</a>\n";
		$html .= "<br />\n";
    }

        $html .= $pn->get_page_link();
        $html .= "<br />\n";

        //$html .= '<table class="pumpform">' . "\n";
        $html .= '<table class="table table-striped table-hover">' . "\n";
        $html .= "<tbody>\n";
        //$form = $form_config['column'];

        $html .= '<tr>';

        foreach ($form as $column) {
            if (@$column['visible'] == 0) {
            continue;
            }
            if (@$column['list_visible'] == 0) {
            continue;
            }
        
            $html .= '<th>';

            if (preg_match('/^([ud])_([_0-9A-Za-z]+)$/', @$_GET['sort'], $r)) {
            $up_down = $r[1];
            $sort = $r[2];
            if ($up_down == 'u') {
                $up_down = 'd';
                $img = $css_url . '/image/down.png';
            } else {
                $up_down = 'u';
                $img = $css_url . '/image/up.png';
            }
            } else {
            $up_down = 'u';
            $sort = false;
            $img = $css_url . '/image/down.png';
            }

            $link = '?sort=' . $up_down . '_';
            $link .= $column['name'];
            if (@$form_config['1n_link_id']) {
                $link .= '&' . $form_config['1n_link_id'] . '=';
                $link .= $_GET[$form_config['1n_link_id']];
            }
            
            $html .= '<a href="' . $link . '">';
            if (@$column['title']) {
            $html .= $column['title'];
            } else {
            $html .= $column['name'];
            }
            if ($column['name'] == $sort) {
            $html .= sprintf('<img src="%s">', $img);
            }
            $html .= '</a>';
            $html .= '</th>';
        }
        $html .= '<th></th>';
        $html .= "</tr>\n";

        $i = 0;
        foreach ($list as $item) {
			$edit_url = '';
			if (!empty($form_config['edit_path'])) {
                if (PC_Util::is_url($form_config['edit_path'])) {
    				$edit_url = sprintf($form_config['edit_path'], $item['id']);
                } else {
    				$edit_url = PC_Config::url() . sprintf($form_config['edit_path'], $item['id']);
                }
			} else if (empty($form_config['do_not_show_edit_button']) || $form_config['do_not_show_edit_button'] == false) {
				$edit_url = $module_url . "/edit/" . $item['id'] . "/" . $url_option;
			}
			$detail_url = '';
			if (!empty($form_config['detail_path'])) {
                if (PC_Util::is_url($form_config['detail_path'])) {
    				$detail_url = sprintf($form_config['detail_path'], $item['id']);
                } else {
    				$detail_url = PC_Config::url() . sprintf($form_config['detail_path'], $item['id']);
                }
			} else if (empty($form_config['do_not_show_detail_button']) || $form_config['do_not_show_detail_button'] == false) {
				$detail_url = $module_url . "/detail/" . $item['id'] . "/" . $url_option;
			}
			
            $i++;
            if ($i % 2) {
            $html .= '<tr>';
            } else {
            $html .= '<tr class="odd">';
            }
            foreach ($form as $column) {
            if (@$column['visible'] == 0) {
                continue;
            }
            if (@$column['list_visible'] == 0) {
                continue;
            }
            $value = @$item[$column['name']];

            if ($i % 2) {
                $html .= '<td>';
             } else {
                $html .= '<td class="odd">';
            }
        
            if ($column['type'] == PUMPFORM_TIME) {
                if ($value == 0) {
                    $html .= 'N/A';
                } else {
                    $html .= strftime('%Y/%m/%d %H:%M', $value);
                }
            } else if ($column['type'] == PUMPFORM_PRIMARY_ID) {
                $html .= intval($value);
            } else if ($column['type'] == PUMPFORM_SELECT ||
		       $column['type'] == PUMPFORM_RADIO) {
                foreach ($column['option'] as $k => $v) {
                    if ($k == $value) {
                        $html .= $v;
                        break;
                    }
                }
            } else if ($column['type'] == PUMPFORM_DATETIME) {
                $html .= strftime('%Y/%m/%d', $value);
            } else if ($column['type'] == PUMPFORM_IMAGE) {
                $o = array();
                if (@$column['crop']) {
                    $o['crop'] = 1;
                }
                $html .= PumpImage::get_tag($value, 120, 120, $o);
            } else {
                $html .= htmlspecialchars(mb_substr($value, 0, 20, 'utf8'));
            }
            $html .= '</td>';
        }
            
        if ($i % 2) {
        $html .= '<td>';
        } else {
        $html .= '<td class="odd">';
        }

	if (!empty($edit_url)) {
        $html .= "<a href='" . $edit_url . "' class='btn btn-default'>" ._MD_PUMPFORM_EDIT . "</a>";
        $html .= "&nbsp;";
	}
    //if (empty($form_config['do_not_show_detail_button']) || $form_config['do_not_show_detail_button'] == false) {
    //    $html .= "<a href='" . $module_url . "/detail/" . $item['id'] . "/" . $url_option . "' class='btn btn-default'>" ._MD_PUMPFORM_DETAIL . "</a>";
    //    $html .= "&nbsp;";
    //}
    If (!empty($detail_url)) {
        $html .= "<a href='" . $detail_url . "' class='btn btn-default'>" . _MD_PUMPFORM_DETAIL . "</a> ";
    }
    //If (empty($form_config['do_not_show_edit_button']) || @$form_config['do_not_show_edit_button'] == false) {
    //    $html .= "<a href='" . $module_url . "/edit/" . $item['id'] . "/" . $url_option . "' class='btn btn-default'>" . _MD_PUMPFORM_EDIT . "</a> ";
    //}
        //$html .= "<a href=''>" . _MD_PUMPFORM_DELETE . "</a> ";
        $html .= "</td>\n";
        $html .= "</tr>\n";
    }
        $html .= "</tbody>\n";
        $html .= "</table>\n";

        $html .= $pn->get_page_link();
        $html .= "<br />\n";

    if (empty($form_config['do_not_show_insert_button']) || $form_config['do_not_show_insert_button'] == false) {
        $html .= "<a href='" . $module_url . "/add/" . $url_option . "' class='btn btn-default'>" . _MD_PUMPFORM_ADD . "</a>\n";
    }
    
    echo $html;

?>



</p>
</div>
                
