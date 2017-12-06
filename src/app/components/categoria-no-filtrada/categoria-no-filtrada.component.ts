import { Component, OnInit } from '@angular/core';
import { ProductosService } from '../../services/productos.service';

@Component({
  selector: 'app-categoria-no-filtrada',
  templateUrl: './categoria-no-filtrada.component.html',
  styles: []
})
export class CategoriaNoFiltradaComponent {

  public productos;
  errorMessage: String;
  constructor(private _productoService: ProductosService) {

   this._productoService.getProductos()
	     .then( data => {
            console.debug(data);
                  this.productos = data;
		    },
        error => this.errorMessage = <any>error);


  }


}
