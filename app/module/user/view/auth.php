
<script type="text/javascript">
<!--

setTimeout('check_telauth()',3000)

function check_telauth() {

    url = '<?php echo PC_Config::url() ?>/user/reload?p=flg_tel_auth';
    $.get(url, {}, check_telauth_res);
}

function check_telauth_res(res) {
    r = res.match(/(\d+)/);

    if (r == null) {
        return;
    }

    if (r[1] == '1') {
        document.getElementById("message1").style.display = "none";
        document.getElementById("message2").style.display = "block";
        return;
    }

    setTimeout('check_telauth()',3000)
}

//-->
</script>

<legend>電話認証</legend>	
<span id="message1" style="font-size: 20px;">
認証コード <span style="font-size: 35px;"><?php echo $this->code ?></span><br />
この数字が電話の音声案内で聞かれます。最大５分程度お待ち下さい。<br />
<br />
<br />
電話が着信しない・認証がうまくいかないなど問題がありましたらお問い合わよりご連絡ください。<br />
<a href="<?php echo PC_Config::url() ?>/contact">お問い合わせ</a>	
</span>
<span id="message2" style="font-size: 20px; display:none;">
認証が終了しました。
</span>
