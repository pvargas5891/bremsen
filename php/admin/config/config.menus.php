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
                'label' => 'Admin Productos',
                'icon' => 'fa fa-circle-o',
                'page' => 'producto-manual'
            ),
             array(
                'label' => 'Admin blog',
                'icon' => 'fa fa-circle-o',
                'page' => 'ingreso-banners'
             ),
             array(
                'label' => 'Descuentos',
                'icon' => 'fa fa-circle-o',
                'page' => 'ingreso-banners'
            )
                ],
            ),



        ],














    ]
];
