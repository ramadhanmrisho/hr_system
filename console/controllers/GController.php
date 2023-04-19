<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class GController extends Controller
{

    public function actionIndex(){
        $where='frontend';
        $template = 'our_template';
        $db_name = 'kcohas_db';
        $tables = Yii::$app->db
            ->createCommand("show tables")
            ->queryAll();
        $tables_=[];
        $result = [];
        $command_1="php ".__DIR__."/../../yii gii/model --ns=common\models --tableName=*  --interactive=0";
        $this->stdout("generating models ");
        if(!exec($command_1,$output,$code) || !$code){
            $this->stderr("failed to generate models");
            return;
        }
        $this->stdout("models generated ");
        //$result[] = $output;
        foreach($tables as $tbl)
        {
            $tables_[]=$tbl['Tables_in_'.$db_name];
            //gen model name
            $table_name=$tbl['Tables_in_'.$db_name];
            $segments=preg_split('/_/', $table_name);

            $model_name='';
            foreach ($segments as $segment) {
                $model_name .= ucfirst($segment);
            }



            $controller_class=$where.'\\controllers\\'.$model_name.'Controller';
            $model_fqn='common\\models\\'.$model_name;
            $search_model='common\\models\\search\\'.$model_name.'Search';
            $viewPath='@'.$where.'\\views\\'.preg_replace('/_/', '-', $table_name);

            $command_2="php yii gii/crud --modelClass=$model_fqn --controllerClass=$controller_class --searchModelClass=$search_model --viewPath=$viewPath --enablePjax=1  --interactive=0 --template=$template";

            exec($command_2,$output,$code);
            $result[] = $output;
            if ($code!=0) break;
        }

        var_dump($code);
        var_dump($result);
        exit("Completed");
    }
}