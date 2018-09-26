import { Component } from '@angular/core';
import { NavController, NavParams, ViewController, ToastController } from 'ionic-angular';
import { Actividad, TipoActividad } from '../../modelos/modelos';
import { HttpProvider } from '../../providers/http/http';

@Component({
  selector: 'page-modal-actividad',
  templateUrl: 'modal-actividad.html',
})
export class ModalActividadPage {

  actividad: Actividad;
  tiposActividad: TipoActividad[];

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private http: HttpProvider,
    public viewCtrl: ViewController,
    private toastCtrl: ToastController) {

    if (this.navParams.get('actividad')) {
      this.actividad = this.navParams.get('actividad');
    } else {
      this.actividad = new Actividad();
    }

    this.http.get('tipo_actividad').then((data: any) => {
      this.tiposActividad = data.data;
    });
  }

  guardarActividad(actividad: any) {

    if (!actividad.nombre || !actividad.fecha_inicio || !actividad.fecha_fin ||
      !actividad.detalle || !actividad.tipo_actividad_id || !actividad.poster) {
      let toast = this.toastCtrl.create({
        message: 'Hay campos vacíos',
        duration: 1500
      });
      toast.present();
    }
    else {
      if (this.actividad.id) {
        this.editar(actividad);
      }
      else {
        this.crear(actividad);
      }
    }
  }

  editar(actividad: any) {

    this.http.put('actividad/' + actividad.id, actividad).then((data: any) => {
      if (data.estado) {
        let toast = this.toastCtrl.create({
          message: 'Actividad editada con éxito',
          duration: 1500
        });
        toast.present();
        this.viewCtrl.dismiss();
      }
    });
  }
  crear(actividad: any) {
    console.log(actividad);
    this.http.post('actividad', actividad).then((data: any) => {
      if (data.estado) {
        let toast = this.toastCtrl.create({
          message: 'Actividad creada con éxito',
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

  guardarPosterActividad($event) {
    var file: File = $event.target.files[0];
    var myReader: FileReader = new FileReader();
    myReader.onloadend = (e) => {
      this.actividad.poster = myReader.result;
    }
    myReader.readAsDataURL(file);
  }


}
