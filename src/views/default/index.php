<?php

use dev7ch\slick\SlickWidget;

?>

<?= SlickWidget::widget([
    'images'            => [],
    'slickConfigWidget' => [
        'infinite'       => 'true',
        'slidesToShow'   => '1',
        'slidesToScroll' => '1',
        'autoplay'       => 'true',
        'autoplaySpeed'  => '5000',
    ],
])
?>