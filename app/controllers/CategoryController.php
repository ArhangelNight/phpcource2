<?php


namespace App\controllers;


use League\Plates\Engine;
use App\models\Category;

class CategoryController
{
    public $templates;
    public $category;

    public function __construct(Category $category, Engine $engine)
    {
        $this->templates = $engine;
        $this->category = $category;
    }

    public function add()
    {
        echo $this->templates->render('admin/category/create');
    }

    public function create()
    {
        $this->category->create($_POST, $_FILES ['image']);
    }

    public function edit(int $id)
    {
        $category = $this->category->getCategory($id);
        echo $this->templates->render('admin/category/edit', ['category' => $category]);
    }

    public function update($id)
    {
        $this->category->update($_POST, $_FILES ['image'], $id);
    }

    public function delete($id)
    {
        $this->category->delete($id);
    }

}