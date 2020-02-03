<?php   

use yii\helpers\Url;
use yii\helpers\Html;


?>

<div style='margin-top:3%;'>
<a href='<?= Url::to(['/pubmed/pubmedfile/get-authors?id_published='.$model->id]); ?>'><h4><?= Html::encode($model->title) ?></h4></a>
<p><?= Html::encode(substr($model->abstract , 0 ,350))?></p>
<p style='fornt-size:10px;'><?=Html::encode($model->source)?></p>
<p style='font-size:12px;'>PMID: <?= Html::encode($model->PMID) ?></p>
</div>
<hr>
						