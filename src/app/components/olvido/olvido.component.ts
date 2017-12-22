import { Component, OnInit } from '@angular/core';

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
  constructor() { }

public recuperaPassword = function (){
    this.loading = true;
    this.userService.update(this.email).then(

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
