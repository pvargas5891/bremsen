import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { UserService } from '../../_services/user.service';
@Component({
  selector: 'app-exito',
  templateUrl: './exito.component.html',
  styles: []
})
export class ExitoComponent implements OnInit {

  constructor(
    private route: ActivatedRoute, 
    private userService: UserService
  ) { }
  public parametros;
  public data;
  ngOnInit() {
    this.route.params.subscribe(parametros => {
      console.debug(parametros);
      this.parametros = parametros;
      this.userService.getVentaByPago(parametros.id).then(
        data => {
          console.debug(data);
          this.data=data;
        }
      );
    });
  }

}
