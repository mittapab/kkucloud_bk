<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\pubmed\models\PublishedsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pubmedfile');
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="publisheds-index">
        <div class="sdbox-body">
            <div class="row">
            <div class='col-md-2'>
              <b> ปีที่ตีพิมพ์ </b>
               <ul class="list-group">
                  <li class="list-group-item">
                  <?php  
                         echo "<details>";
                         echo "<summary> select Year</summary>";
                         $arr_year =[];    
                         
                         foreach($data_year as $row){
                         echo "<a href='".Url::to(['/pubmed/pubmedfile/author-year' , 'year' => $row['year'] ])."'>".$row['year']."</a><br>";
                         //echo '<hr>';
                        }

                        echo "</details>";
                  ?>
                   </li>
              </ul>
              <b> ชื่อผู้แต่ง </b>
               <ul class="list-group">
                  <li class="list-group-item">

                  <?php  
                         echo "<details>";
                         echo "<summary> select Authors</summary>";
                         $arr_fau =[];    
                         
                         foreach($data_authors as $row_fau){
                         echo "<a href='".Url::to(['/pubmed/pubmedfile/author-search' , 'fau' => $row_fau['content']])."'>". $row_fau['content']."</a><br>";
                        //  echo '<hr>';
                        }
                        echo "</details>";
                  ?>
                   </li>
              </ul>
            </div>
                <div class="col-md-10">

                    <?php Pjax::begin(['id' => 'publisheds-grid-pjax']); ?>

                    <?= \yii\grid\GridView::widget([
                        'id' => 'publisheds-grid',
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'columns' => [
                            // [
                            //     'class' => 'yii\grid\CheckboxColumn',
                            //     'checkboxOptions' => [
                            //         'class' => 'selectionPublishedIds'
                            //     ],
                            //     'headerOptions' => ['style' => 'text-align: center;'],
                            //     'contentOptions' => ['style' => 'width:40px;text-align: center;'],
                            // ],
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'text-align: center;'],
                                'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                            ],

                             'PMID',
                              substr('title' , 0 ,50),
                            // 'abstract',
                           
                            [
                                'contentOptions' => ['style'=>'width:80px'],
                                'format' => 'raw',
                                'label' => Yii::t('app',''),
                                'value' => function($model){
                                    $url =  Url::to(['/pubmed/pubmedfile/get-authors?id='.$id.'&id_published='.$model->id]);
                                    $url2 = Url::to(['/pubmed/publisheds/get-issn?id_published='.$model->id]);

                                    $html = "";
                                    $html .=  "<a href='#' class='btn-view-auth' data-url='{$url}'>ดูข้อมูล</a>";
                                    return $html;
                            }
                            ],
                          
                            [
                                'class' => 'appxq\sdii\widgets\ActionColumn',
                                'contentOptions' => ['style' => 'width:80px;text-align: center;'],
                                'template' => '{view} {update} {delete}',
                            ],
                           
                          
                        ],
                    ]); ?>
                   

                  <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>

<?= ModalForm::widget([
    'id' => 'modal-publisheds',
    'size' => 'modal-lg',
]);
?>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>
        $(".btn-view-auth").on('click', function(){
            let url = $(this).attr('data-url');
            // alert(url);
            modalPublished(url);
            return false;
        });
        // JS script
        $('#publisheds-grid-pjax').on('click', '#modal-addbtn-publisheds', function () {
            modalPublished($(this).attr('data-url'));
        });

        $('#publisheds-grid-pjax').on('click', '#modal-delbtn-publisheds', function () {
            selectionPublishedGrid($(this).attr('data-url'));
        });

        $('#publisheds-grid-pjax').on('click', '.select-on-check-all', function () {
            window.setTimeout(function () {
                var key = $('#publisheds-grid').yiiGridView('getSelectedRows');
                disabledPublishedBtn(key.length);
            }, 100);
        });

        $('#publisheds-grid-pjax').on('click', '.selectionPublishedIds', function () {
            var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
            disabledPublishedBtn(key.length);
        });

        $('#publisheds-grid-pjax').on('dblclick', 'tbody tr', function () {
            var id = $(this).attr('data-key');
            modalPublished('<?= Url::to(['publisheds/view', 'id' => ''])?>' + id);
        });

        $('#publisheds-grid-pjax').on('click', 'tbody tr td a', function () {
            var url = $(this).attr('href');
            var action = $(this).attr('data-action');

            if (action === 'update' || action === 'view') {
                modalPublished(url);
            } else if (action === 'delete') {
                yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete this item?')?>', function () {
                    $.post(
                        url
                    ).done(function (result) {
                        if (result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            $.pjax.reload({container: '#publisheds-grid-pjax'});
                        } else {
                            <?= SDNoty::show('result.message', 'result.status')?>
                        }
                    }).fail(function () {
                        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                        console.log('server error');
                    });
                });
            }
            return false;
        });

        function disabledPublishedBtn(num) {
            if (num > 0) {
                $('#modal-delbtn-publisheds').attr('disabled', false);
            } else {
                $('#modal-delbtn-publisheds').attr('disabled', true);
            }
        }

        function selectionPublishedGrid(url) {
            yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete these items?')?>', function () {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: $('.selectionPublishedIds:checked[name=\"selection[]\"]').serialize(),
                    dataType: 'JSON',
                    success: function (result, textStatus) {
                        if (result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            $.pjax.reload({container: '#publisheds-grid-pjax'});
                        } else {
                            <?= SDNoty::show('result.message', 'result.status')?>
                        }
                    }
                });
            });
        }

        function modalPublished(url) {
            $('#modal-publisheds .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
            $('#modal-publisheds').modal('show')
                .find('.modal-content')
                .load(url);
            
            //$this->redirect('/pubmed/index',302);
        }

        function initPublisheds(url){
            //let url = '<?= \yii\helpers\Url::to(['/pubmed/pubmedfile/get-data-publisheds'])?>';
            $.get(url,function (res) {
                $("#preview-pubmedfile").html(res);
            });
        }
        $('.table thead tr th a').on('click',function(){
           let url = $(this).attr('href');
            initPublisheds(url);
           return false;
        });


    </script>
<?php \richardfan\widget\JSRegister::end(); ?>