<script type="text/javascript">
</script>

<!--<div class="twelve columns">-->
<!-- <h3><?php echo $this->title ?></h3> -->
<!--<p>-->

<?php

if (@$message) {
	echo $message;
}

$module_url = PC_Util::get_module_url();

$error = @$this->_data['error'];
$item = @$this->_data['item'];
if (isset($item['id'])) {
    $target_id = $item['id'];
}
$form_config = $GLOBALS['pumpform_config'][$this->_module][$this->_table];
$form = $form_config['column'];

$form_html = '';        
if (isset($target_id)) {
    $form_html .= "<input type='hidden' name='target_id' id='target_id' value='" . intval($target_id) . "'>\n";
}
$form_html .= "<form id='main_form' class='form-horizontal' method='post' enctype='multipart/form-data'>\n";
$form_html .= '<input type="hidden" name="MAX_FILE_SIZE" value="' . PumpFile::get_max_size() . '" />' . "\n";

$form_html .= "<fieldset>\n";
$form_html .= "<legend>" . $this->title .  "</legend>\n";

foreach ($form as $column) {
	if (@$column['visible'] == 0) {
		continue;
	}
	if (@$column['registable'] == 0) {
		continue;
	}

	$form_html .= '<div class="form-group">' . "\n";
	//$form_html .= '  <div class="row">' . "\n";
	$form_html .= '    <label for="inputEmail" class="col-lg-3 col-md-3 col-sm-3 control-label">' . $column['title'] . '</label>' . "\n";
	$form_html .= '    <div class="col-lg-9 col-md-9 col-sm-9 ">' . "\n";
//	if (@$column['hint']) {
//		$form_html .= '<p>' . $column['hint'] . "</p>\n";
//	}

	if ($column['type'] == PUMPFORM_TEXTAREA || 
		$column['type'] == PUMPFORM_TINYMCE ||
		$column['type'] == PUMPFORM_MARKDOWN) {
		$form_html .= "<textarea ";
		if ($column['type'] == PUMPFORM_TEXTAREA) {
			$form_html .= "class='form-control' ";
		} else {
			$form_html .= "class='form-control pump_tinymce' ";
		}
		$form_html .= "name='" . $column['name'] . "'";
		if (@$column['cols']) {
		    $form_html .= " cols='" . intval(@$column['cols']) . "' ";
		}
		if (@$column['rows']) {
		    $form_html .= " rows='" . intval(@$column['rows']) . "' ";
		}
		if (@$column['required']) {
		    $form_html .= ' required ';
		}
	        if (@$column['maxlength']) {
		    $form_html .= " maxlength='" . intval($column['maxlength']) . "' ";
		}
		$form_html .= ">";
		if (@$_POST[$column['name']]) {
		    $form_html .= htmlspecialchars($_POST[$column['name']]);
		} else if (@$item[$column['name']]) {
		    $form_html .= htmlspecialchars($item[$column['name']]);
		}

		$form_html .= "</textarea>";
	} else if ($column['type'] == PUMPFORM_CHECKBOX) {
		$form_html .= "<input type='checkbox'";
		$form_html .= " name='" . $column['name'] . "' ";
		if (@$_POST[$column['name']]) {
		    $form_html .= ' checked ';
		} else if (@$item[$column['name']]) {
		    $form_html .= ' checked ';
		} else if (isset($item[$column['name']]) == false && @$column['default']) {
		    $form_html .= ' checked ';
		}
		$form_html .= "> \n";
	} else if ($column['type'] == PUMPFORM_RADIO) {
		$option = $column['option'];
		foreach ($option as $key => $value) {
			$form_html .= "<input type='radio' ";
			$form_html .= " name ='" . $column['name'] . "' ";
			$form_html .= " value = '" . $key . "' ";
			if (@$_POST[$column['name']] == $key ||
				@$item[$column['name']] == $key ||
				@$column['default'] == $key) {
				$form_html .= ' checked ';
			}
			$form_html .= ">";
			$form_html .= $value;
			$form_html .= "\n";
		}
		$form_html .= "";
	} else if ($column['type'] == PUMPFORM_SELECT) {
		$option = $column['option'];
		$form_html .= "<select name='" . $column['name'] . "'>\n";
		$selected = false;
		foreach ($option as $key => $value) {
			$form_html .= "<option ";
			$form_html .= " value = '" . $key . "' ";
			if ((isset($_POST[$column['name']]) &&
				@$_POST[$column['name']] == $key) ||
				(isset($item[$column['name']]) &&
				@$item[$column['name']] == $key)) {
				$form_html .= ' selected ';
				$selected = true;
			} else if ($selected == false &&
					@$item['id'] == 0 &&
					@$column['default'] == $key) {
				$form_html .= ' selected ';
			}
			$form_html .= ">";
			$form_html .= $value;
			$form_html .= "</option>\n";
		}
		$form_html .= "</select>\n";	
	} else if ($column['type'] == PUMPFORM_IMAGE) {
		if (@$item[$column['name']]) {
			$tmp = PumpImage::get_url_raw($item[$column['name']]);
			if (@$item[$column['name']] && isset($tmp['url'])) {
				$form_html .= sprintf('<a href="%s" target="_blank">', $tmp['url']);
			}
			$form_html .= PumpImage::get_tag($item[$column['name']], 120, 120);
			if (@$item[$column['name']]) {
				$form_html .= '</a>';
			}
			$form_html .= "<br />\n";
			$form_html .= "<labe><input type='checkbox' name='" . $column['name'] . "_delete' value='1'>" . _MD_PUMPFORM_DELETE . "</label><br />\n";
		}
		$form_html .= "<input type='file' name='" . $column['name'] . "' class='pumpform_image'><br />\n";
		$form_html .= 'max size:' . PC_Util::convert_size(PumpUpload::get_max_size());
	        $form_html .= '<div id="' . $column['name'] . '_preview" ></div>';
	} else if ($column['type'] == PUMPFORM_FILE) {
		$form_html .= "<input type='file' name='" . $column['name'] . "'><br />\n";
		$form_html .= 'max size:' . PC_Util::convert_size(PumpUpload::get_max_size());
	} else if ($column['type'] == PUMPFORM_MULTI_CHECKBOX) {
		$t = $column['option']['type'];
		$module = $column['option']['option_table']['module'];
		$table = $column['option']['option_table']['table'];
		if ($t == 'relation') {
			//$op_pumpormap = new PumpORMAP($GLOBALS['pumpform_config'][$module][$table]);
			//$op_pumpormap = PumpORMAP::getInstance($module, $table);
			$op_pumpormap = PumpORMAP_Util::getInstance($module, $table);
			/*
			$s = explode(' ', $form_config['default_sort']);
			echo " default_sort: " . $form_config['default_sort'];
			if ($s[0] == 'd') {
				$r = true;
			} else {
				$r = false;
			}
			*/
			$list = $op_pumpormap->get_list('', 0 , 1000);
			$options = array();
			foreach ($list as $k => $v) {
				$options[$v['id']] = $v['name'];
			}
		} else {
			$options = $column['option']['option'];
		}

		$module = $column['option']['link_table']['module'];
		$table = $column['option']['link_table']['table'];
		$link_pumpormap = PumpORMAP_Util::getInstance($module, $table);

		if (0 < PC_Config::get('shop_id')) {
			$target_id = PC_Config::get('shop_id');
		} else {
			$target_id = PC_Config::get('dir4');
		}
		$link_column = $column['option']['link_table']['id1'];
		$link_list = $link_pumpormap->get_list('`' . $link_column . '` = ' . intval($target_id), 0, 1000);

		$link = array();
		foreach ($link_list as $value) {
			@$link[$value['option_id']] = 1;
		}

		foreach ($options as $key => $option) {
			if ($option == '-') {
				$form_html .= "<br />\n";
				continue;
			}
			if ($option == '--') {
				$form_html .= "<br />\n";
				$form_html .= "<br />\n";
				continue;
			}

			$form_html .= '<label style="display:inline-block;">';
			//$form_html .= '<label>';
			$form_html .= '<input type="checkbox" name="' . $column['name'] . '[]" value="' . $key . '"';
			if($_SERVER['REQUEST_METHOD'] == 'GET') {
				if (@$link[$key]) {
					$form_html .= ' CHECKED';
				}
			} else {
				if (@in_array($key, @$_POST['tag'])) {
					$form_html .= ' CHECKED';
				}
			}

			$form_html .= '>';
			$form_html .=  $option . '</label> ';
		}
		$form_html .= '';
	} else {
			PC_Debug::log($column['name'] . ' OK1 ', __FILE__ , __LINE__);
		if ($column['type'] == PUMPFORM_URL) {
		    $form_html .= '<input class="form-control" type="url" ';
		    //if (@$column['pattern']) {
		    //    $form_html .= ' pattern="' . $column['pattern'] . '" ';
		    //}
		    $form_html .= ' placeholder="'. @$column['placeholder'] . '" autocomplete="off" ';
		} else if ($column['type'] == PUMPFORM_TEXT || $column['type'] == PUMPFORM_INT || $column['type'] == PUMPFORM_ADDRESS_AND_GMAP) {
			PC_Debug::log($column['name'] . ' OK2 ', __FILE__ , __LINE__);
		    $form_html .= '<input class="form-control" type="text" ';
		    if (@$column['pattern']) {
				$form_html .= ' pattern="' . $column['pattern'] . '" ';
		    }
		    $form_html .= ' placeholder="'. @$column['placeholder'] . '" autocomplete="off" ';
		} else if ($column['type'] == PUMPFORM_EMAIL) {
		    $form_html .= '<input class="form-control" class="form-control"  type="email"';
		} else if ($column['type'] == PUMPFORM_YOUTUBE) {
		    $form_html .= '<input class="form-control" class="form-control"  type="text"';
		} else if ($column['type'] == PUMPFORM_PASSWORD) {
		    $form_html .= '<input autocomplete="off" class="form-control" class="form-control"  type="password"';
		}
					PC_Debug::log($column['name'] . ' OK3 ', __FILE__ , __LINE__);
		$form_html .= " name='" . $column['name'] . "' ";
		if ($column['type'] == PUMPFORM_PASSWORD) {
			// do nothing
		} else if (@$_POST[$column['name']]) {
		    $form_html .= " value='". htmlspecialchars($_POST[$column['name']]) . "'";
		} else if (@$item[$column['name']]) {
			$form_html .= " value='". htmlspecialchars($item[$column['name']]) . "'";
		}
		if (@$column['maxlength']) {
			$form_html .= ' maxlength = "' . intval($column['maxlength']) . '"';
		}
		if (@$column['required']) {
		    $form_html .= ' required ';
		}
		if ($column['type'] == PUMPFORM_ADDRESS_AND_GMAP) {
			$form_html .= ' id="gmap_address" ';
		}
		$form_html .= " class='pumpform_input' ";
		$form_html .= ">";	
		if ($column['type'] == PUMPFORM_PASSWORD) {
			// password confirm
			$form_html .= "<br />\n";
			$form_html .= _MD_PUMPFORM_PASSWORD_CONFIRM . "<br />\n";
			$form_html .= '<input autocomplete="off" class="form-control" type="password"';
			$form_html .= " name='" . $column['name'] . "2' ";
			$form_html .= " class='pumpform_input' ";
			$form_html .= ">";		
		}
		if ($column['type'] == PUMPFORM_ADDRESS_AND_GMAP) {
			$form_html .= "<span style='display: inline;'>";
			//$form_html .= '<input type="button" value="search" onclick="search_gmap();">';
			$form_html .= '<input type="button" value="' . _MD_PUMPFORM_SEARCH_MAP . '" onclick="PumpGmapUtil.search_gmap(\'' . _MD_PUMPFORM_INPUT_ADDRESS . '\');">';
			$form_html .= "<span id='map' style='width:100%; height:300px; display:none;'><br></span><br />\n";
			$form_html .= "<input type='hidden' id='geo_lat' name='geo_lat' value='" . @$item['geo_lat'] . "'>\n";
			$form_html .= "<input type='hidden' id='geo_lng' name='geo_lng' value='" . @$item['geo_lng'] . "'>\n";
			$form_html .= "</span>\n";
		}
    }
    $form_html .= "\n";
	if (@$column['hint']) {
		$form_html .= '<p>' . $column['hint'] . "</p>\n";
	}    
	if (@$error[$column['name']]) {
		$form_html .= "<br /><span class='pumpcms_error_message'>*" . $error[$column['name']] . "</span><br />";
	}
	$form_html .= "    </div> <!-- end control-label -->\n";
	//$form_html .= "  </div> <!-- end row -->\n";
	$form_html .= "</div> <!-- end form-group -->\n";
}

$form_html .= "
    <div class='form-group'>
      <div class='col-lg-10 col-lg-offset-2'>\n";

if (@$form_config['captcha'] && PumpCaptcha::is_operable()) {
	echo '<img src="' . PC_Config::url() . '/image/captcha">'; 
}

if (@$form_config['submit_caption']) {
	$form_html .= $form_config['submit_caption'] . "<br />\n";
}

$form_html .= "
        <!--<button class='btn btn-default'>Cancel</button>-->
        <input type='reset' class='btn btn-default'>
        <!--<button type='submit' class='btn btn-primary'>Submit</button>-->
        <input type='submit' class='btn btn-primary' id='submit_button'>
      </div>
    </div>\n";

$form_html .= "</fieldset>\n";
	
echo $form_html;
$form_html = '';
?>

<?php if (PumpForm::$redirect_url) : ?>
<a href="<?php echo PumpForm::$redirect_url; ?>" class='btn btn-default'><?php echo _MD_PUMPFORM_BACK ?></a>
<?php else : ?>
<a href="<?php echo PC_Config::get('base_url') . '/' . PC_Config::get('dir1') . '/' . PC_Config::get('dir2') . '/'; ?>" class='btn btn-default'><?php echo _MD_PUMPFORM_BACK ?></a>
<?php endif ; ?>

<?php

if (PC_Config::get('dir3') == 'edit' && is_numeric(PC_Config::get('dir4')) || PumpForm::$file == 'edit') {
	if (PumpForm::$delete_url) {
		$delete_url = sprintf(PumpForm::$delete_url, $item['id']);
	} else if (PC_Config::get('dir3') == 'edit' && is_numeric(PC_Config::get('dir4')))	 {
		$delete_url = $module_url . '/delete/' . PC_Config::get('dir4') . '/';
	} else {
		$delete_url = $module_url . '/delete/' . $item['id'] . '/';
	}

	$form_html .= "<input type='hidden' id='pumpform_delete_confirm' value='" . htmlspecialchars(_MD_PUMPFORM_DELETE_CONFIRM) . "'>\n";


	if (PC_Config::get('delete_post_redirect')) {
		$delete_post_redirect = PC_Config::get('delete_post_redirect');
		$form_html .= "<input type='hidden' id='delete_post_redirect' value='" . $delete_post_redirect . "/'>\n";
	}
	
	$form_html .= "<input type='hidden' id='pumpform_module_url' value='" . $module_url . "/'>\n";
	$form_html .= "<input type='hidden' id='pumpform_delte_url' value='" . $delete_url . "'>\n";
	$form_html .= "<input type='button' id='pumpform_delete_button' value='" . _MD_PUMPFORM_DELETE . "'  class='btn btn-default'><br />\n";
}

$form_html .= "</form>\n";

echo $form_html;

