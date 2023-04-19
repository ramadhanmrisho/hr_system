<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (preg_match('#created_at|updated_at#',$column->name)){
            echo "            '" . $column->name . ":datetime',\n";
        }elseif (preg_match('#created_by#',$column->name)){
            echo "            '" . "createdBy.fullName',\n";
        }elseif (preg_match('#.*_id$#',$column->name)){
            $name = Inflector::id2camel(preg_replace('/_id/','',$column->name),'_');

            $class ="\common\models\\".$name;
            $class2 ="\common\models\\".$name.'s';
            $name = lcfirst($name);

            try{
                new ReflectionMethod($generator->modelClass,'get'.$name);

                $reflectionMethod = new ReflectionMethod($class, 'getTableSchema');
                $schema=$reflectionMethod->invoke(null);

                if ($schema->getColumn("name")!=null){
                    echo "           ['attribute':'" . $column->name. "','value':'{$name}.name']\n";
                }else{
                    echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }catch (\ReflectionException $e){
                try{
                    new ReflectionMethod($generator->modelClass,'get'.$name);

                    $reflectionMethod2 = new ReflectionMethod($class2, 'getTableSchema');
                    $schema2=$reflectionMethod2->invoke(null);

                    if ($schema2->getColumn("name")!=null){
                        echo "           ['attribute':'" . $column->name. "','value':'{$name}.name']\n";
                    }else{
                        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                }catch (\ReflectionException $e){
                    echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }
        }else{
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
        ],
    ]) ?>

</div>
