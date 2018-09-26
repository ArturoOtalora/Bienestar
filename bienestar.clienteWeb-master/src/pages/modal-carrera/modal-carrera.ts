import { Component } from '@angular/core';
import { NavController, NavParams, ViewController, ToastController } from 'ionic-angular';
import { Carrera, Facultad } from '../../modelos/modelos';
import { HttpProvider } from '../../providers/http/http';

@Component({
  selector: 'page-modal-carrera',
  templateUrl: 'modal-carrera.html',
})
export class ModalCarreraPage {

  carrera: Carrera;
  facultades: Facultad[];

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private viewCtrl: ViewController,
    private http: HttpProvider,
    private toastCtrl: ToastController) {


    if (this.navParams.get('data')) {
      this.carrera = this.navParams.get('data');
    } else {
      this.carrera = new Carrera();
    }
    this.http.get('facultad').then((data: any) => this.facultades = data.data);
  }

  guardar() {
    if (!this.carrera.nombre) {
      const toast = this.toastCtrl.create({
        message: "hay campos vacíos",
        duration: 3000
      });
      toast.present();
    }
    else {
      if (this.carrera.id) {
        this.http.put('carrera/' + this.carrera.id, this.carrera).then((data: any) => this.viewCtrl.dismiss());
      } else {
        this.http.post('carrera', this.carrera).then((data: any) => this.viewCtrl.dismiss());
      }
    }
  }

  dismiss() {
    this.viewCtrl.dismiss();
  }

}
