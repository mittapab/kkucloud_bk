<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pubmedfile */

$this->title = $model->file_name;//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pubmedfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pubmedfile-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>
<!-- 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'file_name',
        ],
    ]) ?> -->
    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <form class="form-inline" style='float:right'>
      <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search"
        aria-label="Search">
      <button type="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-search"></span> Search 
        </button>
   </form> 
   <br>
   <br>
   <br>
    <table class='table table-bordered'>
    <thead >
     <tr style='text-align:center;'>
      <th width='5%' style='text-align:center;'> No</th>
      <th width='10%'style='text-align:center;'>PMID</th>
      <th width='30%' style='text-align:center;'>Title</th>
      <th width='30%'style='text-align:center;'>Authors</th>
      <th width='15%' style='text-align:center;'>Status</th>
      <th style='text-align:center;'>Actions</th>
     </tr>
    </thead>
    <tbody>
     <?php  
     $i = 1;
     foreach($model as $row){ ?>
        
        <tr>
         <td><?= $i++; ?></td>
         <td><?= $row['PMID']?></td>
         <td><?= $row['title']?></td>
         <td>
           <?php
             foreach($model_au as $row_au){ 
               echo $row_au['content'].', ';  
             }
           ?>
         </td>
         <td><?= $row['status']?></td>
         <td style='text-align:center;'>
         <?= Html::button('<span class="glyphicon glyphicon-eye-open"></span>', [                        

'value' => Yii::$app->urlManager->createUrl('/some-controller/some-action'),

'class' => 'btn btn-secondary',

'id' => 'BtnModalId',

'data-toggle'=> 'modal',

'data-target'=> '#your-modal',

]) ?>

<?= Html::button('<span class="glyphicon glyphicon-download-alt"></span>' , [ 'class' => 'btn btn-secondary'])?>

         <!-- <a href="#" alt='view'>
          <span class="glyphicon glyphicon-eye-open"></span>
        </a> &nbsp; -->
        <!-- <a href="#"  alt='download'>
          <span class="glyphicon glyphicon-download-alt"></span>
        </a> -->
         </td>
      </tr>
     

    <?php  } ?>
    </tbody>
    
    
    
    </table>

<!-----------------------------------------modal start--------------------------------------------->
    
<?php                 

Modal::begin([

        'header' => '<h4 style="background:#1a8cff; padding:10px;color:#ffffff;">Paper</h4>',

        'id' => 'your-modal',

        'size' => 'modal-lg',

    ]);

echo "<div id='modalContent'>";

?>
<hr>
<div class="row">
<div class="col-md-12">
<?php foreach($model as $row){ ?>

<p><?= $row['source']?>[Epub <?= $row['publication_status']?>]</p>
<h4><b><?= $row['title']?></b></h4>
<p>
<?php foreach($model_au as $row_au){ echo  Html::a($row_au['content'],['/']).', ';   }  ?>
</p>
<h4>Authors Information</h4>
<p>

<?php 

$i = 1;
foreach($model_ad as $row_ad){ 

  echo  $i.'. '.$row_ad['content'].' <br> ';   
  
  $i++;
  }  
  
  
  ?>
</p>
<hr>
<h4>Aubstract</h4>
<p><?= $row['abstract'] ?></p>

<p><?= $row['copyright_Information'] ?></p>
<p>PMID: <?= $row['PMID'] ?></p>

<?php }  ?>

</div>
</div>

<?php  echo "</div>";

Modal::end();

?>

</div>



