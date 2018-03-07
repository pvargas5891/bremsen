import { Component, OnInit,ViewChild } from '@angular/core';
import { OwlCarousel } from 'ngx-owl-carousel';
import { ProductosService } from '../../services/productos.service';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-bremsen',
  templateUrl: './bremsen.component.html',
  styles: []
})

export class BremsenComponent implements OnInit {
  public productos = [];
  public errorMessage: String;
  public nombreCompleto: String;
  public email:String;
  public mensaje:String;

  @ViewChild("f")
  f: NgForm;

  constructor(public _productoService: ProductosService,
    private route: Router) {

    this._productoService.getProductosHome('sugerido')
      .then(data => {
        //console.debug(data);
        this.productos = data;

       // console.debug(this.productos);
      },
      error => this.errorMessage = <any>error);
    window.scrollTo(0, 0);
   }

  ngOnInit() {
  }
  public estadoEnvio: boolean = false;
  enviaCorreo =function(){

      
    this._productoService.enviacontacto(this.nombreCompleto, this.email, this.mensaje).then(
      data => {
        this.estadoEnvio = true;
        this.f.resetForm();
      },
      error =>{
        console.debug(error);
        this.estadoEnvio = true;
      }
    );
  }

}
