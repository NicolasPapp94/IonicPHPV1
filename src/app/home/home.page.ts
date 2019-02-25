import { Component } from '@angular/core';
import { Http } from '@angular/http';
import { LoadingController } from '@ionic/angular';
@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {
      respuesta_servidor=[];
      constructor(public http:Http,public Loading: LoadingController){}

      TraerDatos(){
        this.PonerLoading();
        var link = 'http://barberia.ironhide.com.ar/API_BARBERIA.php'; //RUTA QUE ESTA EN EL SERVIDOR
        var datos = JSON.stringify({opcion:"VerTurnos", ID: 2});
        this.http.post(link,datos).subscribe(respuesta =>{
              this.SacarLoading();
              this.respuesta_servidor = JSON.parse(respuesta['_body']);
              console.log(this.respuesta_servidor);
        }, error =>{
            console.log(error);
        })
      }

      LimpiarDatos(){
        this.respuesta_servidor = [];
      }


      async PonerLoading() {
        return await this.Loading.create({message:'Cargando...'}).then(a => {
          a.present().then(() => {});});
      }
      async SacarLoading() {
        return await this.Loading.dismiss();
      }
}
