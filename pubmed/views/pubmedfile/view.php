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
        
        let url = '<?= \yii\helpers\Url::to(['/pubmed/pubmedfile/get-data-publisheds' , 'id' => $_GET['id']])?>';
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
       let url = '<?= \yii\helpers\Url::to(['/pubmed/pubmedfile/get-data-publisheds', 'id' => $_GET['id']])?>&term='+term;
     
       searchPublisheds(url);
       return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>

 
</div>



