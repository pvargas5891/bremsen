import { Component, OnInit } from '@angular/core';
import { UserService } from '../../_services/user.service';
import { Cliente } from '../../components/registro/cliente';
@Component({
  selector: 'app-misdatos',
  templateUrl: './misdatos.component.html',
    styleUrls: ['./misdatos.component.css']
})
export class MisdatosComponent implements OnInit {

  public cliente = new Cliente();
  public id: string;
 constructor(private userService: UserService
                ) {

        var currentUser = JSON.parse(localStorage.getItem('currentUser'));
        //this.id = currentUser;
        console.debug(currentUser);
        //this.getDatosPersonales();
        //this.getHistorialCliente();
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
