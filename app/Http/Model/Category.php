<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
//    use SoftDeletes;
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;

    protected $fillable = [
        'cate_name',
        'cate_title',
        'cate_keywords',
        'cate_description',
        'cate_view',
        'cate_order',
        'cate_pid',
    ];

    public function tree()
    {
        $categories = $this->orderBy('cate_order', 'asc')->get();//获取模型内所有的数据
        return $this->getTree($categories, 'cate_name', 'cate_id', 'cate_pid');
    }

    public function getTree($data, $field_name, $field_id = 'id', $field_pid = 'pid', $pid = 0)
    {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v->$field_pid == $pid) {
                $data[$k]["_" . $field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m => $n) {
                    if ($n->$field_pid == $v->$field_id) {
                        $data[$m]["_" . $field_name] = '——' . $data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
