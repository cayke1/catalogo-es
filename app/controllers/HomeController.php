<?php

class HomeController extends RenderView {
    public function index() {

        $product = new ProductModel();
        $args=[
            'title' => $product->listAll(),
        ];
        $this->loadView('partials/header',['title' => 'List Products']);
        $this->loadView('partials/cards',$args);
    }
}