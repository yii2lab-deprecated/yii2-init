<?php

/* @var $this yii\web\View */
/* @var $htmlstring */

$this->title = Yii::t('init/requirements', 'title');

?>

<div class="box box-primary">
	<div class="box-body">
		<?= !empty($html) ? $html : SPC ?>
	</div>
</div>