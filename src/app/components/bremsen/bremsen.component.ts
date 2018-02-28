import { Component, OnInit } from '@angular/core';
import { OwlCarousel } from 'ngx-owl-carousel';
import { ProductosService } from '../../services/productos.service';
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
  constructor(public _productoService: ProductosService) {

    this._productoService.getProductosHome('sugerido')
      .then(data => {
        //console.debug(data);
        this.productos = data;

        console.debug(this.productos);
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
      },
      error =>{
        console.debug(error);
        this.estadoEnvio = true;
      }
    );
  }

}
