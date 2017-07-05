<?php $tel_code = rand(10, 99); ?>
          <div class="col-lg-12">
                    <!--<div class="well bs-component">-->
                      <form class="form-horizontal" method="post" action="<?php echo PC_Config::url() ?>/user/telauth/auth">
                              <input type="hidden" name="post" value="1">
                                              <fieldset>
                          <legend><?php echo _MD_USER_TEL_AUTH ?></legend>
        電話で認証を行います。
        下記で入力された電話番号へ当サイトから自動で連絡されます。費用はかかりません。<br />
        <br />
                          <div class="form-group">
                            <label for="inputId" class="col-lg-3 control-label">電話番号</label>
                            <div class="col-lg-9">
                                <select name="tel_country">
                                <option value="+1">US,Canada +1</option>
                                <option value="+62" selected>Indonesia +62</option>
                                <option value="+81" selected>日本 +81</option>
                                <option value="+82">Korea +82</option>
                                <option value="+852">Hong Kong +852</option>
                                <option value="+886">Taiwan +886</option>
                                </select>
                              <input required type="text" class="form-control" id="inputId" placeholder="電話番号を入力してください" name="tel" value="" pattern="^[0-9\-]+$" title="電話番号"><br />
                                                  </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail" class="col-lg-3 control-label">認証コード</label>
                            <div class="col-lg-9">
                              <!--<input required type="email" class="form-control" id="inputEmail" placeholder="認証コードを入力してください" name="email" value="">-->
                                <span style="font-size:32px; font-weight: bold;"><?php echo $tel_code ?></span><br /> この数字が電話の音声案内で聞かれます
                                <input type="hidden" name="tel_code" value="<?php echo $tel_code ?>">
                                                  </div>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                              <!--<button class="btn btn-default">Cancel</button>-->
                              <button type="submit" class="btn btn-primary">認証を行う</button>
                            </div>
                          </div>
                        </fieldset>
                      </form>
                    <!--</div>-->
                  </div> <!-- end col-lg-12 -->        