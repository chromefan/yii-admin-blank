<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = Yii::$app->params['siteName'];

?>

    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="page-header">
            <h1>
                灰度升级
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    灰度与条件下发
                </small>
            </h1>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 widget-container-col ui-sortable" style="min-height: 210px;">
                <!-- #section:custom/widget-box -->
                <div class="widget-box ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h5 class="widget-title">条件语句规则</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <ul>
                                <li>支持符号 && || == != >= <= > <，意思跟程序里一样。</li>
                                <li>用比较符号时 >= <= > < 会把值转为数值进行对比。例如 userId>200000，即使客户端调用 +setupUserData: 接口时设置的 userId 字段是字符串，也会转为数值进行对比。</li>
                                <li>使用 == != 符号时，会以字符串形式判断是否相等，例如 1.0 == 1 结果是 NO。</li>
                                <li>等式的值不需要引号，字符串也不需要，例如：location!=guangdong 支持多个条件，例如：userId!=31242&&location==guangdong&&name==bang</li>
                                <li>若多个条件里同时有 && 和 ||，&& 的优先级较高。例如 userId<200000||location==guangdong&&name==bang，会先分别计算 userId<200000 和 location==guangdong&&name==bang 的结果，再进行 || 运算。</li>
                            </ul>
                            <div>
                                <?php $form = ActiveForm::begin([
                                    'id' => 'rule-form',
                                    'options' => ['class' => 'form-horizontal'],
                                    'action'  => ['site/checkrule']
                                ]); ?>
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <input type="text" id="form-field-1-1" placeholder="升级规则" class="form-control" name="rule_text"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <?= Html::submitButton('测试一下', ['class' => 'btn btn-primary', 'name' => 'login-button','id' => 'login-button']) ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8" id="rule-msg">
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>

                            </div><!-- /.span -->
                        </div>
                    </div>
                </div>
                <!-- /section:custom/widget-box -->
            </div>
            <div class="col-xs-12 col-sm-8 widget-container-col ui-sortable" style="min-height: 210px;">
                <!-- #section:custom/widget-box -->
                <div class="widget-box ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h5 class="widget-title">按比例升级</h5>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <?php $form = ActiveForm::begin([
                                'id' => 'hash-form',
                                'options' => ['class' => 'form-horizontal'],
                                'action'  => ['site/hashcode']
                            ]); ?>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <input type="number" id="form-field-1-1" placeholder="设置比例:15%" class="form-control" name="scale"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <input type="text" id="form-field-1-1" placeholder="标识+版本号" class="form-control" name="deviceId"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8">
                                    <?= Html::submitButton('计算HashCode', ['class' => 'btn btn-primary', 'name' => 'login-button','id' => 'login-button']) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8" id="hash-msg">
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

                <!-- /section:custom/widget-box -->
            </div>
        </div>
        <div class="row marge-top-bg">

        </div><!-- /.row -->


        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->

<?php
$js = <<<JS
// get the form id and set the event
$('#rule-form').on('beforeSubmit', function(e) {
   var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'post',
        dataType: "json",
        data: form.serialize(),
        success: function (result) {
            console.log(result);
            if(result.status==1){
                success(result.info,'rule-msg');
            }else{
                error(result.info,'rule-msg');
            }
         }
       });
   // do whatever here, see the parameter \$form? is a jQuery Element to your form
}).on('submit', function(e){
    e.preventDefault();

});
$('#hash-form').on('beforeSubmit', function(e) {
   var form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'post',
        dataType: "json",
        data: form.serialize(),
        success: function (result) {
            console.log(result);
            if(result.status==1){
                success(result.info,'hash-msg');
            }else{
                error(result.info,'hash-msg');
            }
         }
       });
   // do whatever here, see the parameter \$form? is a jQuery Element to your form
}).on('submit', function(e){
    e.preventDefault();

});
function error(msg,div){
    var html='';
    html='<p class="alert alert-warning">'+msg+'</p>';
    $('#'+div).html(html);
}
function success(msg,div){
    var html='';
    html='<p class="alert alert-success">'+msg+'</p>';
    $('#'+div).html(html);
}
JS;
$this->registerJs($js);
