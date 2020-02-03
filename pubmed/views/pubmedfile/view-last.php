<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pubmedfile */

$this->title = $model->file_name; //$model->id;
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

    
<br>
<div class="row">
    <div class="col-md-6 col-md-offset-6">
        <form id="form-search">
            <div class="input-group">
                <input id="term" type="text" class="form-control" placeholder="ค้นหาข้อมูล">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i> ค้นหา
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<br>
<div id="preview-publisheds"></div>

<?php \richardfan\widget\JSRegister::begin(); ?>
<script>
    function initPublisheds(){
        let url = '<?= \yii\helpers\Url::to(['/pubmed/publisheds/get-data'])?>';
        searchPublisheds(url);
    }
    function searchPublisheds(url){
        $.get(url,function (res) {
            $("#preview-publisheds").html(res);
        });
    }
    initPublisheds();

    $("#form-search").on('submit', function () {
       let term = $("#term").val();
       let url = '<?= \yii\helpers\Url::to(['/pubmed/publisheds/get-data'])?>?term='+term;
       searchPublisheds(url);
       return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>

    <table class='table table-bordered'>
    <thead >
     <tr style='text-align:center;'>
      <th width='5%' style='text-align:center;'>No</th>
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
     ///วนลูปค่าจาก publish มาแสดง
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
              'value' => Yii::$app->urlManager->createUrl("pubmed/pubmedfile/get-authors?id_published=".$row['id']),
              'class' => 'btn btn-secondary',
              'id' => 'BtnModalId-'.$row['id'],
              //'data-toggle'=> 'modal',
              //'data-target'=> '#your-modal',
            ]) ?>

          <?= Html::button('<span class="glyphicon glyphicon-download-alt"></span>' , [ 'class' => 'btn btn-secondary'])?>
          
          <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg"> 
              <!-- Modal content-->
              <div class="modal-content" style='text-align:left;'>
              </div>
            </div>
          </div>
          
          
          <?php \richardfan\widget\JSRegister::begin()?>
          <script>
              $("#BtnModalId-"+<?=$row['id']?>).on('click',function(){
                  let url = $(this).val();
                  $.get(url, function(result){ 
                     $("#myModal").modal('show');
                     $("#myModal .modal-content").html(result);
                  });
                  return false;
              });
          </script>
          <?php \richardfan\widget\JSRegister::end()?>
          
         </td>
      </tr>
     

    <?php   }  ?>
    
    </tbody>
    
    
    
    </table>
</div>



