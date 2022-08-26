<?php


namespace app\assets;


use yii\web\AssetBundle;

/**
 * Class LandingAsset for open landing pages
 * @package app\assets
 */
class LandingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/normalize.css',
        'css/landing.css'
    ];
    public $js = [
        'js/landing.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}