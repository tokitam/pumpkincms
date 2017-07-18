<?php
$link = $this->_data['item'];
?>
        
<ul class="breadcrumb">
    <li><a href="<?php echo PC_Config::url(); ?>">Home</a></li>
    <li class="active"><?php echo htmlspecialchars($link['title']) ?></li>
</ul>        
        
      <div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="indicators"><?php echo htmlspecialchars($link['title']) ?></h1>
            </div>
          </div>
        </div> <!-- row -->

        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <a href="<?php echo $link['url'] ?>">
            <?php echo PumpImage::get_tag($link['screenshot1'], 500, 375, ['crop' => 0, 'width100p' => 1]); ?>
            </a>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="page-header">
              <?php printf('<a href="%s">%s</a>', $link['url'], $link['url']) ?><br />
            </div>
           <?php echo htmlspecialchars($link['desc']) ?><br />
           <?php
           $tag_list = explode(',', $link['tag']);
           if (!empty($tag_list)) {
           foreach ($tag_list as $tag) :
              if (!empty($tag)) {
           ?>
           <span class="label label-info label-link"><a href="<?php echo PC_Config::url() ?>/link/?tag=<?php echo htmlspecialchars($tag) ?>"><?php echo htmlspecialchars($tag) ?></a></span>
           <?php
               }
           endforeach ;
           }
           if (PC_Grant::check($this->_module, $this->_table, 'grant_edit', $link['reg_user'])) :
           ?>
           <br />[ <a href="<?php echo PC_Config::url() . '/link/index/edit/' . $link['id']; ?>">編集</a> ] 
           <?php endif ; ?>
        
          </div>
        </div> <!-- row -->

        <div class="row">
          <div class="col-lg-12">
            <br />
          </div>
        </div> <!-- row -->
        
        <div class="row">
          <?php if (! empty($link['screenshot2'])) : ?>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <?php echo PumpImage::get_tag($link['screenshot2'], 500, 500, ['crop' => 1, 'width90p' => 1]); ?>
          </div>
          <?php endif ; ?>
          <?php if (! empty($link['screenshot3'])) : ?>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <?php echo PumpImage::get_tag($link['screenshot3'], 500, 500, ['crop' => 1, 'width90p' => 1]); ?>
          </div>
          <?php endif ; ?>
          <?php if (! empty($link['screenshot4'])) : ?>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <?php echo PumpImage::get_tag($link['screenshot4'], 500, 500, ['crop' => 1, 'width90p' => 1]); ?>
          </div>
          <?php endif ; ?>
        </div> <!-- row -->
      </div>
