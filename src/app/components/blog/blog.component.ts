import { Component, OnInit } from '@angular/core';
import { InformacionService } from '../../services/informacion.service';
import { ActivatedRoute, Router } from '@angular/router';
@Component({
  selector: 'app-blog',
  templateUrl: './blog.component.html',
  styles: []
})
export class BlogComponent{
  public blogs: any[]=[];

  constructor(public _is: InformacionService, 
    private route: ActivatedRoute,
    private routeLink: Router) { 

    _is.getBlog().then(
      data => {
       
        this.blogs=data;
        console.debug(data);
    });

  }


}
