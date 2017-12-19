import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../_services/index';

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
     constructor(
        private authenticationService: AuthenticationService) {

          var currentUser = JSON.parse(localStorage.getItem('currentUser'));
          if(currentUser.token === 'active'){
              this.autenticado = true;
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
                    this.autenticado = true;
                    this.loading = false;
                } else {
                    // login failed
                    this.error = 'Usuario y password son incorrectos';
                    this.loading = false;
                }
            });
    }
}
