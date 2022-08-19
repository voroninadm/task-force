<?php


namespace app\widgets;


use yii\base\Widget;

/**
 * Class RatingStars
 * Отрисовка звездочек на основании рейтинга исполнителя (юзера)
 * @package app\widgets
 */
class RatingStars extends Widget
{
    public float $rating;
    const STAR_RATING = 5;

    public function run()
    {
        for ($i = 1; $i <= self::STAR_RATING; $i++) {
            if ($this->rating >= $i) {
                echo '<span class="fill-star">&nbsp;</span>';
            } else {
                echo '<span>&nbsp;</span>';
            }
        }
    }
}