<?php

require_once PUMPCMS_ROOT_PATH . '/external/parsedown/Parsedown.php';

$module_url = PC_Util::get_module_url();

$form = $GLOBALS['pumpform_config'][$this->_module][$this->_table]['column'];
$item = $this->_data['item'];

?>

<div>
<form class="form-horizontal">
<fieldset>
<legend><?php echo htmlspecialchars($this->title) ?></legend>
<?php
foreach ($form as $column) {

	if (@$column['visible'] == 0) {
		continue;
	}
	echo '<div class="form-group">' . "\n";

	echo '<label class="col-lg-3 col-md-3 col-sm-3 control-label">' . $column['title'] . '</label>' . "\n";

	$form_html = '<div class="col-lg-9 col-md-9 col-sm-9 control-item">' . "\n";
	$value = @$item[$column['name']];

	if ($column['type'] == PUMPFORM_PASSWORD) {
		$form_html .= '********';
	} else if ($column['type'] == PUMPFORM_TIME) {
		if ($value == 0) {
			$form_html .= 'N/A';
		} else {
			$form_html .= strftime('%Y/%m/%d %H:%M', $value);
		}
	} else if ($column['type'] == PUMPFORM_URL) {
		$form_html .= sprintf('<a href="%s" target="_blank">%s</a>', $value, $value);
	} else if ($column['type'] == PUMPFORM_IMAGE) {
		$o = array('link' => 1);
		if (@$column['crop']) {
			$o['crop'] = 1;
		}
		$form_html .= PumpImage::get_tag($value, 300, 300, $o);
	} else if ($column['type'] == PUMPFORM_FILE) {
		$form_html .= PumpFile::get_tag($value);
	} else if ($column['type'] == PUMPFORM_MULTI_CHECKBOX) {
		$module = $column['option']['option_table']['module'];
		$table = $column['option']['option_table']['table'];
		$op_pumpormap = PumpORMAP_Util::getInstance($module, $table);
		$option_list = $op_pumpormap->get_list();

		$option = array();
		foreach ($option_list as $key => $value) {
			$option[$value['id']] = $value['name'];
		}
	
		$module = $column['option']['link_table']['module'];
		$table = $column['option']['link_table']['table'];
		$link_pumpormap = PumpORMAP_Util::getInstance($module, $table);

		$link_column = $column['option']['link_table']['id1'];
		$id2 = $column['option']['link_table']['id2'];
		$link_list = $link_pumpormap->get_list('`' . $link_column . '` = ' . intval(PC_Config::get('dir4')));

		foreach ($link_list as $key => $value) {
			if ($value == '--') {
				continue;
			}
			$form_html .= '<span>'. @$option[$value[$id2]] . '</span> ';
		}
	} else if ($column['type'] == PUMPFORM_ADDRESS_AND_GMAP) {
		$form_html .= "<div>" . htmlspecialchars($value) . "</div><br />\n";
		$form_html .= "<div id='map' style='width:400px; height:400px;'><br>\n</div>\n";
		$form_html .= "<div id='gmap_address' style='display: none;'>". $item['geolocation'] . "</div>\n";
		$form_html .= sprintf('<a href="https://maps.google.com/maps?q=%s&z=15" target="_blank">%s</a>', $item['geolocation'], _MD_PUMPFORM_LARGE_MAP);
	} else if ($column['type'] == PUMPFORM_SELECT) {
		foreach ($column['option'] as $k => $v) {
			if ($k == $value) {
				$form_html .= $v;
				break;
			}
		}
	} else if ($column['type'] == PUMPFORM_TEXTAREA) {
		$form_html .= nl2br(htmlspecialchars($value));
	} else if ($column['type'] == PUMPFORM_MARKDOWN) {
		$Parsedown = new Parsedown();
		$form_html .= $Parsedown->text($value); 
	} else if ($column['type'] == PUMPFORM_TINYMCE) {
		$form_html .= PC_Util::strip_tags($value);
	} else if ($column['type'] == PUMPFORM_YOUTUBE) {
		@preg_match('/v=([_0-9A-Za-z\-]+)/', $value, $r);
		if (@$r[1]) {
			$form_html .= sprintf('<iframe width="300" height="168" src="//www.youtube.com/embed/%s" frameborder="0" allowfullscreen></iframe>', $r[1]);
		}
	} else {
		$form_html .= htmlspecialchars($value);
	}
	$form_html .= "\n";
	$form_html .= "</div>\n";
	echo $form_html;

	echo '</div> <!-- end form-group -->' . "\n";

}
?>
</fieldset>
</form>
<?php
$form_html = '';
if (@PC_Config::get('dir3') == 'delete' || PumpForm::$file == 'delete') {
	$form_html .= "<form method='post'>\n";
	$form_html .= "<input type='submit' onclick='return confirm(\"" . _MD_PUMPFORM_DELETE_CONFIRM . "\");' value='" . _MD_PUMPFORM_DELETE . "'>";
	$form_html .= "</form>\n";
}

if (UserInfo::is_master_admin() || UserInfo::is_site_admin()) {
	if (PumpForm::$edit_url) {
		$form_html .= sprintf('<a href="' . PumpForm::$edit_url . '">' . _MD_PUMPFORM_EDIT . '</a>', $item['id']);
	} else {
		$form_html .= "<a href='" . PC_Config::get('base_url') . '/' . PC_Config::get('dir1') . '/' . PC_Config::get('dir2') . "/edit/" . PC_Config::get('dir4') . "/' class='btn btn-default'><nobr>" . _MD_PUMPFORM_EDIT . "</nobr></a> ";
	}
}
$form_html .= "<br />\n";

echo $form_html;

?>
</div>

<?php if (PumpForm::$redirect_url) : ?>
<a href="<?php echo PumpForm::$redirect_url; ?>" class='btn btn-default'><?php echo _MD_PUMPFORM_BACK ?></a>
<?php else : ?>
<a href="<?php echo $module_url; ?>" class='btn btn-default'><?php echo _MD_PUMPFORM_BACK ?></a>
<?php endif ; ?>
<?php echo PumpForm::$redirect_url ?>
