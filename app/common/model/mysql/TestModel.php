<?php
namespace app\common\model\mysql;

use think\Model;

class TestModel extends Model
{
        // 设置当前模型对应的完整数据表名称
        protected $table = 'tp6_test';
        // 设置字段信息
        protected $schema = [
            'id'            => 'int',
            'title'         => 'string',
            'pass'          => 'string',
            'category_id'   => 'int',
            'create_time'   => 'string',
            'update_time'   => 'string',
            'status'        =>'string',
        ];

        public function getTestModelTp6_testCategoryId($category_id,$limit){
            /*if(empty($category_id))
            {
                return [];    
            }*/
            $result=$this->where('category_id',$category_id)
            ->limit($limit)
            ->select();
            
            return $result;
        }
    
}