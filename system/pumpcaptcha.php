<?php
/**
 * PumpCaptcha - Very simple captcha library for php/gd
 *
 * # Required
 * -PHP5
 * -GD
 * -.ttf TrueType Font file
 * 
 * # example
 *
 * ```
 * <?php session_start(); ?><html>
 * <head>
 *     <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.js"></script>
 * </head>
 * <body>
 * <form method="post">
 *	captcha:<br />
 *	<input type="text" name="captcha_text">
 *	<input type="submit"><br />
 *	<img src="pumpcaptcha.php" id="captcha_image"><br />
 * <input type="button" value="reload" onclick="src=$('#captcha_image').attr('src'); $('#captcha_image').attr('src', src + '?' + new Date().getTime());"><br />
 * </form>
 * <br />
 * <?php
 * if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 *     if (strtolower($_POST['captcha_text']) == strtolower($_SESSION['pumpcaptcha_text'])) {
 *	echo 'captcha OK';
 *    } else {
 *	echo 'captcha NG';
 *    }
 * }
 * ?>
 * </body>
 * </html>
 * ```
 * 
 * The MIT License (MIT)
 * 
 * Copyright (c) 2015 Masahiko Tokita http://github.com/tokitam
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

//session_start();

$pumpcaptcha = new PumpCaptcha(PUMPCMS_ROOT_PATH . '/resource/OpenSans-Regular.ttf');
$pumpcaptcha->output_image();
exit();

class PumpCaptcha 
{
    var $width = 150;
    var $height = 70;
    var $font = 'OpenSans-Regular.ttf';
    var $border = 5;
    var $pumpcaptcha_text = 'pumpcaptcha_text';
    
    public function __construct($font=false)
    {
        if ($font) {
            $this->font = $font;
        }
    }
    
    public function output_image() 
    {
	$im = imagecreate($this->width, $this->height);
	imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 0, 0, 0);
        $gray  = imagecolorallocate($im, 146 + rand(-30, 30), 146 + rand(-30, 30), 146 + rand(-30, 30));
        $white  = imagecolorallocate($im, 255, 255, 255);
	imagefilledrectangle($im, 0, 0, $this->width, $this->height, $gray);
	imagefilledrectangle($im, $this->border - 1, $this->border - 1, $this->width - $this->border, $this->height - $this->border, $white);

        for($i=0; $i<10; $i++) {
	    imageline($im, rand(0, $this->width - 1), rand(0, $this->height - 1), rand(0, $this->width - 1), rand(0, $this->height - 1), $gray);
	}

	$x = 10 + rand(0, 40);
	$y = 40 + rand(0, 15);
	$font = $this->get_font_path();
	$font_size = 30;
	$text = $this->generate_string();
	$_SESSION[$this->pumpcaptcha_text] = $text;
    //echo ' font: ' . $font;
 	imagettftext($im, $font_size, 0, $x, $y, $gray, $font, $text);
	
        header('Content-type: image/jpeg');
        imagejpeg($im, null, 20);
    }
    
    private function generate_string()
    {
	$string = '345689' .
	  'abefghjkmnprstwxy';
	$len = strlen($string);
	
	return substr($string, rand(0, $len - 1), 1) . 
	  substr($string, rand(0, $len - 1), 1) . 
	  substr($string, rand(0, $len - 1), 1);
    }
    
    private function get_font_path()
    {
	//return './' . $this->font;
        return $this->font;
    }
    
    private function check_gd()
    {
        return function_exists('ImageCreateTrueColor');
    }
}
