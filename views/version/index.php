<?php
/**
 * Created by PhpStorm.
 * User: luohuanjun
 * Date: 16/12/14
 * Time: 上午10:26
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = Yii::$app->params['siteName'];
?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">应用上传</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">应用名称</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="应用名称">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">版本号</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="版本号">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">升级包</label>
                        <input type="file" id="exampleInputFile">

                        <p class="help-block">Example block-level help text here.</p>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> 最大支持32M
                        </label>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-info">提交</button>
                </div>
            </form>
        </div>
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">按比例升级</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $form = ActiveForm::begin([
                'id' => 'hash-form',
                'action'  => ['version/hashcode']
            ]); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">设置比例:15%</label>
                        <input type="number" id="form-field-1-1" placeholder="设置比例:15%" class="form-control" name="scale"/>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">标识+版本号</label>
                        <input type="text" id="form-field-1-1" placeholder="标识+版本号" class="form-control" name="deviceId"/>
                    </div>
                    <div class="form-group" id="hash-msg">
                        <p class="help-block">Example block-level help text here.</p>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?= Html::submitButton('计算HashCode', ['class' => 'btn btn-primary', 'name' => 'login-button','id' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- /.box -->

    </div>
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">条件升级</h3>
            </div>
            <div class="box-body">
                <ul>
                    <li>支持符号 && || == != >= <= > <，意思跟程序里一样。</li>
                    <li>用比较符号时 >= <= > < 会把值转为数值进行对比。例如 userId>200000，即使客户端调用 +setupUserData: 接口时设置的 userId 字段是字符串，也会转为数值进行对比。</li>
                    <li>使用 == != 符号时，会以字符串形式判断是否相等，例如 1.0 == 1 结果是 NO。</li>
                    <li>等式的值不需要引号，字符串也不需要，例如：location!=guangdong 支持多个条件，例如：userId!=31242&&location==guangdong&&name==bang</li>
                    <li>若多个条件里同时有 && 和 ||，&& 的优先级较高。例如 userId<200000||location==guangdong&&name==bang，会先分别计算 userId<200000 和 location==guangdong&&name==bang 的结果，再进行 || 运算。</li>
                </ul>
                <?php $form = ActiveForm::begin([
                    'id' => 'rule-form',
                    'action'  => ['version/checkrule']
                ]); ?>
                <div class="form-group">
                        <input type="text" id="form-field-1-1" placeholder="升级规则" class="form-control" name="rule_text"/>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('测试一下', ['class' => 'btn btn-success', 'name' => 'login-button','id' => 'login-button']) ?>
                </div>
                <div class="form-group" id="rule-msg">
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
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