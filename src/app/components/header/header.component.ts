import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../_services/index';
import { Router } from '@angular/router';

@Component({
  selector: 'app-header',
  moduleId: module.id,
  templateUrl: './header.component.html',

})
export class HeaderComponent implements OnInit {
model: any = {};
    loading = false;
    returnUrl: string;
    error = '';
    autenticado = false;
    nombreCliente = "";
     constructor(
        private authenticationService: AuthenticationService,
        private route: Router) {

          var currentUser = JSON.parse(localStorage.getItem('currentUser'));

          if(currentUser != null){
             console.debug(currentUser);
            if(currentUser.token === 'active'){
                this.nombreCliente = currentUser.usuario.nombre;
                this.autenticado = true;
            }
          }
         }

    ngOnInit() {
        // reset login status
       // this.authenticationService.logout();
    }

login() {
        this.loading = true;
        this.authenticationService.login(this.model.username, this.model.password)
            .then(result => {
                console.debug(result);
                if (result === true) {
                    // login successful
                    //this.router.navigate(['/']);
                  var currentUser = JSON.parse(localStorage.getItem('currentUser'));
                  console.debug(currentUser);
                    this.nombreCliente = currentUser.usuario.nombre;
                    this.autenticado = true;
                    this.loading = false;
                } else {
                    // login failed
                    this.error = 'Usuario y password son incorrectos';
                    this.loading = false;
                }
            });
    }
     logout(): void {
            // clear token remove user from local storage to log user out
          //this.token = null;
          localStorage.removeItem('currentUser');
         this.autenticado = false;
         this.route.navigate(['/home']);
        }
}
