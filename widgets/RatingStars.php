<?php


namespace app\widgets;


use Yii;
use yii\base\Widget;

/**
 * Class RatingStars
 * Отрисовка звездочек на основании рейтинга исполнителя (юзера)
 * @package app\widgets
 */
class RatingStars extends Widget
{
    public float $rating;

    public function run()
    {
        for ($i = 1; $i <= Yii::$app->params['starRating']; $i++) {
            if ($this->rating >= $i) {
                echo '<span class="fill-star">&nbsp;</span>';
            } else {
                echo '<span>&nbsp;</span>';
            }
        }
    }
}