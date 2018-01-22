import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { InformacionService } from '../../../services/informacion.service';
@Component({
  selector: 'app-contenido',
  templateUrl: './contenido.component.html'

})
export class ContenidoComponent{

  public blogs: any[] = [];
  constructor(private route: ActivatedRoute,
    private routeLink: Router,
    public _is: InformacionService) { 
   
    this.route.params.subscribe(parametros => {
      //console.debug(parametros);
      _is.getBlogUnico(parametros).then(
        data => {

          this.blogs = data;
        });
    });

    }


}
