import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-exito',
  templateUrl: './exito.component.html',
  styles: []
})
export class ExitoComponent implements OnInit {

  constructor(private route: ActivatedRoute) { }
  public parametros;
  ngOnInit() {
    this.route.params.subscribe(parametros => {
      console.debug(parametros);
      this.parametros = parametros;

    });
  }

}
