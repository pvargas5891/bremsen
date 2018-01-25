<?php
$config['menu'] = [
    'admin' => [



        'default' => [

            array(
                'label' => 'Administrador',
                'icon' => 'fa fa-dashboard',
                'page' => [
            array(
               'label' => 'Ventas Web',
               'icon' => 'fa fa-circle-o',
               'page' => 'ventas'
            ),
            array(
                'label' => 'Agregar desde Discogs',
                'icon' => 'fa fa-circle-o',
                'page' => 'discog'
            ),

            array(
                'label' => 'Admin Productos',
                'icon' => 'fa fa-circle-o',
                'page' => 'producto-manual'
            ),

            array(
                'label' => 'Admin Tags',
                'icon' => 'fa fa-circle-o',
                'page' => 'tags'
            ),
             array(
                'label' => 'Banner Home',
                'icon' => 'fa fa-circle-o',
                'page' => 'ingreso-banners'
            ),
            array(
               'label' => 'Banner Tienda',
               'icon' => 'fa fa-circle-o',
               'page' => 'banners-tienda'
           ),


                ],
            ),



        ],














    ]
];
