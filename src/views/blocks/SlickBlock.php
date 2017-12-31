<?php
use dev7ch\slick\SlickWidget;

$images = $this->extraValue('images');

?>

<?= SlickWidget::widget([
    'images'            => $images,
    'slickConfigWidget' => [
        'infinite'       => 'true',
        'slidesToShow'   => '1',
        'slidesToScroll' => '1',
        'autoplay'       => 'true',
        'autoplaySpeed'  => '5000',
    ],
]);
