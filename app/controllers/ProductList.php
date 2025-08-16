<?php 

class ProductList extends RenderView
{
    public function list()
    {
        $product = new ProductModel();
        $args=[
            'title' => $product->listAll(),
        ];
        $this->loadView('partials/header',['title' => 'List Products']);
        $this->loadView('partials/cards',$args);
    }
}