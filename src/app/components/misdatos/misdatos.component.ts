import { Component, OnInit } from '@angular/core';
import { UserService } from '../../_services/user.service';
import { Cliente } from '../../components/registro/cliente';

import { Router } from '@angular/router';

@Component({
  selector: 'app-misdatos',
  templateUrl: './misdatos.component.html',
    styleUrls: ['./misdatos.component.css']
})
export class MisdatosComponent implements OnInit {

  public cliente = new Cliente();
  public id: string;
 constructor(private userService: UserService,
              private route: Router
                ) {

       var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          //console.debug
          if(currentUser != null){
            if(currentUser.token === 'active'){
                this.id = currentUser.usuario.id;
            }else{
                this.route.navigate(['/home']);
            }

          }else{
            this.route.navigate(['/home']);
          }
    }

  ngOnInit() {
  }

  private getDatosPersonales = function (){

        this.userService.getById(this.id).then(
          data => {



          }
        );

  }
      private getHistorialCliente = function (){

        this.userService.getHistorialById(this.id).then(
          data => {



          }
        );

  }
}
