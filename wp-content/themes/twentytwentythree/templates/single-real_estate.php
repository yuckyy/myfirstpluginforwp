<?php
// Получение значений полей ACF
$house_name = get_field( 'house_name' );
$coordinates = get_field( 'coordinates' );
$floor_count = get_field( 'floor_count' );
$building_type = get_field( 'building_type' );
?>

<!-- Вывод полей на странице -->
<h2><?php echo $house_name; ?></h2>
<p>Координаты: <?php echo $coordinates; ?></p>
<p>Количество этажей: <?php echo $floor_count; ?></p>
<p>Тип строения: <?php echo $building_type; ?></p>
