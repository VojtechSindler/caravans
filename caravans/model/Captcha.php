<?php

namespace Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Captcha extends \Nette\Object {

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $minWorldLength;

    /**
     * @var int
     */
    private $maxWorldLength;

    /**
     * @var array
     */
    private $colors = array();
    private $image;
    private $charset = array("A", "B", "C", "D", "E", "F", "G", "H", "J", "K",
        "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", 2, 3, 4, 5, 6, 7, 8, 9);
    
    private $font = "../www/fonts/corbelb.ttf";

    public function __construct($width, $height, $minWorldLenght, $maxWorldLength) {
        $this->width = $width;
        $this->height = $height;
        $this->minWorldLength = $minWorldLenght;
        $this->maxWorldLength = $maxWorldLength;
    }

    public function createImage() {
        $this->image = imagecreate($this->width, $this->height);
        $background = imagecolorallocate($this->image, 255, 255, 255);
        imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $background);
        $this->randomColors()
                ->drawWords()
                ->drawNoise();
        return $this;
    }
    
    public function show(){
        header("content-type: image/jpeg");
        imagejpeg($this->image);    
        return $this;
    }

    /**
     * Uloží obrázek a vrátí cestu.
     * @return string
     */
    public function save(){
        return CaptchaFileStorage::create("captcha")->save($this->image)->getImage();
    }
    
    public function match($text){
        if(!CaptchaSolver::match($text)) throw new CaptchaException();
    }
    
    private function randomColors() {
        for ($i = 0; $i < 30; $i++) {
            $this->colors[] = imagecolorallocate($this->image, rand(1, 255), rand(1, 255), rand(1, 255));
        }
        return $this;
    }

    private function countWords() {
        return mt_rand($this->minWorldLength, $this->maxWorldLength);
    }

    private function drawWords() {
        $_SESSION["originalText"] = null;
        $count = $this->countWords();
        $distance = 5; //px
        $text = null;
        for ($i = 0; $i < $count; $i++) {
            $char = $this->charset[array_rand($this->charset)];
            imagettftext($this->image, rand(45, 50), -30 + rand(0, 60), 
                    $distance, 50 + rand(0, 10), 
                    $this->colors[array_rand($this->colors)], 
                    $this->font, $char);
            $distance += rand(30, 45);
            $text .= $char; 
        }
        CaptchaSolver::originalText($text);
        return $this;
    }

    private function drawNoise() {
        for ($i = 0; $i < 800; $i++) {
            $x1 = rand(5, $this->width - 5);
            $y1 = rand(5, $this->height - 5);
            $x2 = $x1 - 4 + rand(0, 8);
            $y2 = $y1 - 4 + rand(0, 8);
            imageline($this->image, $x1, $y1, $x2, $y2, $this->colors[rand(0, count($this->colors) - 1)]);
        }
        return $this;
    }

}

class CaptchaSolver{
    public static function originalText($text){
        if(!isset($_SESSION["originalText"]))
            $_SESSION["originalText"] = null;
        $_SESSION["originalText"] = \Nette\Security\Passwords::hash($text);
    }
    public static function match($text){
        return \Nette\Security\Passwords::verify($text, $_SESSION["originalText"]);
    }
}

class CaptchaFileStorage extends \Nette\Object{
    
    private $path;
    
    private $quality = 85;
    
    private static $image;
    
    public function __construct($path) {
        $this->path = $path;
    }
    
    public function getPath(){
        return $this->path;
    }
    
    public function getImage(){
        return self::$image;
    }
    
    public static function create($path){
        return new CaptchaFileStorage(self::createName($path));
    }
    
    public function save($image){
        imagejpeg($image, $this->path, $this->quality);
        return $this;
    }
    
    private static function createName($dir){
        $name = null;
        do{
            $name = self::generateRandomName();
            self::$image = $name;
            $name = $dir.DIRECTORY_SEPARATOR.$name;
        }while(self::exists($name));
        return $name;
    }
    
    private static function exists($file){
        return file_exists($file);
    }
    
    private static function generateRandomName(){
        return \Nette\Utils\Strings::random(5, "a-zA-Z0-9").'.jpg';
    }
}

class CaptchaException extends \Exception{ }