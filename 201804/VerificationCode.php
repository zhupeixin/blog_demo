<?php
/**
 * Created by PhpStorm.
 * User: 朱培鑫
 * Date: 2016/4/17
 * Time: 11:08
 */
// 命名空间，请将本文件放入App\Lib目录下
namespace App\Lib;
/**
 * 生成验证码
 * Class VerificationCode
 */
class VerificationCode {
    protected $image;
    protected $width;
    protected $height;
    protected $data;
    protected $num;
    protected $path;
    protected $strvalue="";

    /**
     * @param int $width
     * @param int $height
     * @param int $num
     * @param int $font_size
     * @param int $model
     * @param int $point_num
     * @param int $line_num
     */
    public function __construct($width,$height,$point_num,$line_num,$num=4,$font_size=6,$model=1){
        $this->width = $width;
        $this->height = $height;
        $this->num = $num;
        //创建白色底图
        $this->image = imagecreatetruecolor($this->width,$this->height);
        $bjcolor = imagecolorallocate($this->image,255,255,255);
        imagefill($this->image,0,0,$bjcolor);
        //填入验证码
        for($i = 0;$i<$this->num;$i++){
            $content = $this->CreateRandData($this->DataModel($model));
            $fontcolor = imagecolorallocate($this->image,rand(0,120),rand(0,120),rand(0,120));
            $x = rand(5,10)+$i*$this->width/$this->num;
            $y = rand(5,10);
            imagestring($this->image,$font_size,$x,$y,$content,$fontcolor);
        }
        //产生干扰
        $this->point($point_num);
        $this->line($line_num);
    }

    /**
     * 验证码产生数据模式
     * @param int $model
     * @return string
     */
    protected function dataModel($model){
        $str = "";
        switch ($model){
            //纯数字模式
            case 1:$str = "0123456789";
                break;
            //纯小写字母模式
            case 2:$str = "qwertyuiopasdfghjklzxcvbnm";
                break;
            //大小写随机模式
            case 3:$str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
                break;
            //数字字母随机模式
            case 4:$str = "0123456789qwertyuiopasdfghjklzxcvbnm";
                break;
            //数字大小写字母随机模式
            case 5:$str = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
                break;
            //数字字母安全识别模式
            case 6:$str = "23456789qwertyupasdfghjkzxcvbnm";
                break;
        }
        return $str;
    }
    protected function createRandData($str){
        $s = substr($str,rand(0,strlen($str))-1,1);
        $this->strvalue.=$s;
        return $s;
    }
    /**
     * 用于输出图片
     */
    public function showImage(){
        $newName = md5(time().$this->strvalue).".png";
        $this->path = 'temp/'.$newName;
        header('content-type:image/jpeg');
        imagejpeg($this->image,$this->path);
        return url($this->path);
    }

    /**
     * 用于
     * @return string
     */
    public function value(){
        return $this->strvalue;
    }

    /**
     * 产生点干扰
     * @param int $point_num 干扰点数目
     */
    protected function point($point_num=0){
        for($i=0;$i<$point_num;$i++){
            $pointcolor = imagecolorallocate($this->image,rand(50,200),rand(50,200),rand(50,200));
            imagesetpixel($this->image,rand(1,$this->width-1),rand(1,$this->height),$pointcolor);
        }
    }

    /**
     * 产生线干扰
     * @param int $line_num 干扰线数目
     */
    protected function line($line_num=0){
        for($i=0;$i<$line_num;$i++){
            $linecolor = imagecolorallocate($this->image,rand(80,220),rand(80,220),rand(80,220));
            imageline($this->image,rand(1,$this->width-1),rand(1,$this->height-1),rand(1,$this->width-1),rand(1,$this->height-1),$linecolor);
        }
    }

    /**
     * 析构函数，销毁图片
     */
    public function __destruct(){
        imagedestroy($this->image);
    }
}