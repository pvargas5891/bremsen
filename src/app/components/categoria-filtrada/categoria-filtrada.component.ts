import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
@Component({
  selector: 'app-categoria-filtrada',
  templateUrl: './categoria-filtrada.component.html',
  styles: []
})
export class CategoriaFiltradaComponent implements OnInit {

  constructor(private route: ActivatedRoute) {

      route.params.subscribe( parametros =>{
            console.debug(parametros);
      });

  }

  ngOnInit() {
  }

}
