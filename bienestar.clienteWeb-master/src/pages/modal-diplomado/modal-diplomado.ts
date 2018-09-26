import { Component } from '@angular/core';
import { NavController, NavParams, ViewController, ToastController } from 'ionic-angular';
import { Diplomado, Facultad } from '../../modelos/modelos';
import { HttpProvider } from '../../providers/http/http';

@Component({
  selector: 'page-modal-diplomado',
  templateUrl: 'modal-diplomado.html',
})
export class ModalDiplomadoPage {

  diplomado: Diplomado;
  facultades: Facultad[];

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private http: HttpProvider,
    public viewCtrl: ViewController,
    private toastCtrl: ToastController) {

    if (this.navParams.get('diplomado')) {
      this.diplomado = this.navParams.get('diplomado');
    } else {
      this.diplomado = new Diplomado();
    }

    this.http.get('facultad').then((data: any) => {
      this.facultades = data.data;
    });
  }
  guardarDiplomado(diplomado: any) {

    if (!diplomado.nombre || !diplomado.fecha_inicio || !diplomado.fecha_fin ||
      !diplomado.facultad_id || !diplomado.vacantes) {
      let toast = this.toastCtrl.create({
        message: 'Hay campos vacíos',
        duration: 1500
      });
      toast.present();
    }
    else {
      if (this.diplomado.id) {
        this.editar(diplomado);
      }
      else {
        this.crear(diplomado);
      }
    }
  }

  editar(diplomado: any) {

    this.http.put('diplomado/' + diplomado.id, diplomado).then((data: any) => {
      if (data.estado) {
        let toast = this.toastCtrl.create({
          message: 'diplomado editado con éxito',
          duration: 1500
        });
        toast.present();
        this.viewCtrl.dismiss();
      }
    });
  }
  crear(diplomado: Diplomado) {

    this.http.post('diplomado', diplomado).then((data: any) => {
      if (data.estado) {
        let toast = this.toastCtrl.create({
          message: 'diplomado creado con éxito',
          duration: 1500
        });
        toast.present();
        this.viewCtrl.dismiss();
      }
    });
  }

  dismiss() {
    this.viewCtrl.dismiss();
  }

}
