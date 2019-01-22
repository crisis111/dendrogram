<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/14 0014
 * Time: 下午 2:40
 */

namespace DenDroGram\Controller;

use DenDroGram\Helpers\Func;
use DenDroGram\Model\AdjacencyListModel;
use DenDroGram\ViewModel\AdjacencyListViewModel;

class AdjacencyList implements Structure
{
    private static $view = <<<EOF
<style>%s</style>
<script>%s</script>
%s
<div id="mongolia"></div>
<script>
dendrogram.tree.init();
</script>
EOF;

    /**
     * @param bool $expand
     * @param array $column
     * @param string $form_content
     * @return string
     */
    public static function buildTree($expand = true,array $column = ['name'],$form_content = '')
    {
        $css = file_get_contents(__DIR__.'/../Static/dendrogram.css');
        $js = file_get_contents(__DIR__.'/../Static/dendrogram.js');

        $result = AdjacencyListModel::orderBy('p_id','ASC')->orderBy('sort','DESC')->get();
        $data = [];
        if($result){
            $data = $result->toArray();
        }

        $html = (new AdjacencyListViewModel($expand,$column,$form_content))->index($data);

        return sprintf(self::$view,$css,$js,$html);
    }

    /**
     * @return mixed
     */
    public static function getTreeStructure()
    {
        $data = [
            ["id"=>1,"p_id"=>0,"name"=>"中国"],
            ["id"=>2,"p_id"=>1,"name"=>"四川"],
            ["id"=>3,"p_id"=>1,"name"=>"北京"],
            ["id"=>4,"p_id"=>2,"name"=>"成都"],
            ["id"=>5,"p_id"=>2,"name"=>"绵阳"]
        ];

        Func::quadraticArrayToTreeStructure('id','p_id',$data,$tree);
        return $tree;
    }

    public static function getTreeData()
    {
        $data = [
            ["id"=>1,"p_id"=>0,"name"=>"中国"],
            ["id"=>2,"p_id"=>1,"name"=>"四川"],
            ["id"=>3,"p_id"=>1,"name"=>"北京"],
            ["id"=>4,"p_id"=>2,"name"=>"成都"],
            ["id"=>5,"p_id"=>2,"name"=>"绵阳"]
        ];

        Func::quadraticArrayToTreeData('id','p_id','children',0,$data,$tree);
        return $tree;
    }

    public static function operateNode()
    {
        // TODO: Implement updateNode() method.
    }

}