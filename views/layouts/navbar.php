<?php
/**
 * Created by PhpStorm.
 * User: luohuanjun
 * Date: 16/7/22
 * Time: 下午2:54
 */
?>
<?php
$menu=\app\models\Menu::getMenuList();
$route= Yii::$app->controller->getRoute();
?>
<ul class="nav nav-list">
    <li class="">
        <a href="index.html">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> 控制台 </span>
        </a>
        <b class="arrow"></b>
    </li>
    <?php foreach($menu as $k =>$v){ ?>
        <li class=" <?php if($k==0){ echo 'active open';} ?>">
            <a href="<?=$v['url']?>" class="dropdown-toggle">
                <i class="menu-icon fa fa-desktop"></i>
                <span class="menu-text"> <?= $v['name']?> </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <?php foreach($v['sub'] as $sub) {
                    if($route==$sub['url']){
                        $active='active';
                    }else{
                        $active='';
                    }
                    ?>
                <li class="<?=$active?>">
                    <a href="<?php echo \yii\helpers\Url::to([$sub['url']]);?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <?php echo $sub['name'];?>
                        <b class="arrow"></b>
                    </a>
                </li>
                <?php }?>
            </ul>
        </li>
    <?php }?>
</ul>