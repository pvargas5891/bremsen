import { Component, OnInit } from '@angular/core';
import { UserService } from "../../_services/user.service";
@Component({
  selector: 'app-olvido',
  templateUrl: './olvido.component.html',
  styles: []
})
export class OlvidoComponent {
  loading = false;
  estado:boolean = false;
  returnUrl: string;
  error = '';
  email: string = "";
  constructor(public userService: UserService,) { }

public recuperaPassword = function (){
    this.loading = true;
    this.userService.recuperaPassword(this.email).then(

      data=>{
          this.loading = false;
          if(data=='OK'){
            this.estado = true;
          }else{
            this.error = "No encontramos tu email, revisalo y vuelve a intentar";
          }
      }

    );
  }

}
