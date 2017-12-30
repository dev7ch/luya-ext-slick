<?php
use dev7ch\slick\SlickWidget;


echo SlickWidget::widget([
    'images'            => $this->extraValue('images'),
    'slickConfigWidget' => [
        'infinite'       => 'true',
        'slidesToShow'   => '2',
        'slidesToScroll' => '1',
        'autoplay'       => 'true',
        'autoplaySpeed'  => '5000',
    ],
]);
