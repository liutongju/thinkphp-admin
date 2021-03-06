<?php

namespace Admin\Controller;

class NewsController extends __Controller {

    protected $form = array(
        'title' => array(
            'title' => '标题',
            'type' => 'text',
            'name' => 'title'
        ),
        'category_id' => array(
            'title' => '分类',
            'type' => 'select',
            'name' => 'category_id'
        ),
        'cover_image_id' => array(
            'title' => '封面图',
            'type' => 'uploadPicture',
            'name' => 'cover_image_id'
        ),
        'is_video' => array(
            'title' => '是否视频',
            'remark' => '视频文章将会在封面图右上角显示特殊标记',
            'type' => 'select',
            'name' => 'is_video',
            'options' => array(
                0 => '否',
                1 => '是'
            )
        ),
        'is_recommended' => array(
            'title' => '是否推荐',
            'remark' => '被推荐的文章将会显示在文章右侧推荐区域',
            'type' => 'select',
            'name' => 'is_recommended',
            'options' => array(
                0 => '否',
                1 => '是'
            )
        ),
        'excerpt' => array(
            'title' => '摘要',
            'remark' => '显示在列表页，字数在250字以内',
            'type' => 'textarea',
            'name' => 'excerpt'
        ),
        'detail' => array(
            'title' => '内容',
            'type' => 'editor',
            'name' => 'detail'
        )
    );

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $categorys = D('NewsCategory')->getField('id,title');
        $this->form['category_id']['options'] = $categorys;
    }

    public function index() {
        $this->meta_title = '资讯列表';
        $list = $this->lists($this->model,array('status' => array('egt',0)),'create_time desc');

        if($list) {
            foreach($list as &$item) {
                $item['category_name'] = $this->form['category_id']['options'][$item['category_id']];
            }
        }

        $this->assign('_list_',$list);
        $this->display();
    }

    public function add() {
        if(IS_POST) {
            $this->redirect = U('index');
        }
        else {
            $this->meta_title = $this->title = '添加资讯';
        }
        parent::add();
    }

    public function edit($id)
    {
        if(!IS_POST) {
            $item = $this->model->where(array('id' => $id))->find();
            $this->form['cover_image_id']['image'] = get_images($item['cover_image_id']);

            $this->meta_title = $this->title = '编辑商品';
            $this->redirect = U('index');
        }
        parent::edit($id);
    }

    public function delete($id)
    {
        parent::delete($id); // TODO: Change the autogenerated stub
    }

    public function status($id, $value)
    {
        parent::status($id, $value); // TODO: Change the autogenerated stub
    }

    public function sort($id, $value)
    {
        parent::sort($id, $value); // TODO: Change the autogenerated stub
    }

}