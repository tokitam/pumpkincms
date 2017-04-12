<?php
$pn = $this->_data['pagenavi'];
$list = $this->_data['list'];

foreach ($list as $link) :
?>

        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-3">
	    <a href="<?php echo PC_Config::url() . '/link/' . intval($link['id']) . '/'; ?>">
            <?php echo PumpImage::get_tag($link['screenshot1'], 500, 375, ['crop' => 0, 'width100p' => 1]); ?>
	    </a>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7">
            <div class="page-header">
              <h3 id="indicators"><?php echo htmlspecialchars($link['title']) ?></h3>
	    </div>
              <?php echo htmlspecialchars(PC_Util::mb_truncate($link['desc'], 60)) ?><br />
	   <?php
           $tag_list = explode(',', $link['tag']);
           foreach ($tag_list as $tag) :
           ?>
	   <span class="label label-info"><?php echo htmlspecialchars($tag) ?></span>
	   <?php
           endforeach ; 
           ?>
	  </div>
        </div> <!-- row -->

        <div class="row">
	  <div class="col-lg-12">
	    <br />
	  </div>
	</div> <!-- row -->
	
<?php
endforeach ;

echo $pn->get_page_link();
	