<? defined('KOOWA') or die('Restricted access') ?>

<? if (defined('JDEBUG') && JDEBUG) : ?>
<script src="com_locations/js/map.google.js" />
<? else: ?>
<script src="com_locations/js/min/map.google.min.js" />
<? endif; ?>

<div class="an-map" data-locations="<?= $locations ?>"></div>
