import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import { Observable } from 'rxjs';
import { UserService } from '../_services/user.service';
import { Cliente } from '../components/registro/cliente';
import 'rxjs/add/operator/map'
 
@Injectable()
export class AuthenticationService {
    public token: string;
 
    constructor(private userService: UserService
                ) {
        // set token if saved in local storage
        var currentUser = JSON.parse(localStorage.getItem('currentUser'));
        this.token = currentUser && currentUser.token;
    }
 
    login(username: string, password: string): Promise<boolean> {
        let registro = new Cliente();

        return this.userService.loginUserService(registro).then( response => {

                if ( response[0] === 'OK') {
                    // set token property
                    this.token = 'active';
 
                    // store username and jwt token in local storage to keep user logged in between page refreshes
                    localStorage.setItem('currentUser', JSON.stringify({ usuario: response[1], token: this.token }));
 
                    // return true to indicate successful login
                    return true;
                } else {
                    // return false to indicate failed login
                    return false;
                }
          });
   
    }
 
    logout(): void {
        // clear token remove user from local storage to log user out
      //  this.token = null;
      //  localStorage.removeItem('currentUser');
    }
}
