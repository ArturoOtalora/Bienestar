import { Component } from '@angular/core';
import { NavController, NavParams, ViewController, ToastController } from 'ionic-angular';
import { TipoActividad } from '../../modelos/modelos';
import { HttpProvider } from '../../providers/http/http';

@Component({
  selector: 'page-modal-tipo-actividad',
  templateUrl: 'modal-tipo-actividad.html',
})
export class ModalTipoActividadPage {

  tipoActividad: TipoActividad;

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private viewCtrl: ViewController,
    private http: HttpProvider,
    private toastCtrl: ToastController) {

    if (this.navParams.get('data')) {
      this.tipoActividad = this.navParams.get('data');
    } else {
      this.tipoActividad = new TipoActividad();
    }
  }

  guardar() {
    if (!this.tipoActividad.nombre) {
      const toast = this.toastCtrl.create({
        message: "hay campos vacíos",
        duration: 3000
      });
      toast.present();
    }
    else {
      if (this.tipoActividad.id) {
        this.http.put('tipo_actividad/' + this.tipoActividad.id, this.tipoActividad).then((data: any) => this.viewCtrl.dismiss());
      } else {
        this.http.post('tipo_actividad', this.tipoActividad).then((data: any) => this.viewCtrl.dismiss());
      }
    }
  }

  dismiss() {
    this.viewCtrl.dismiss();
  }

}
