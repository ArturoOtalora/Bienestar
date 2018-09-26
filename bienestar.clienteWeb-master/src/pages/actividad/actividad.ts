import { DetalleActividadPage } from './../detalle-actividad/detalle-actividad';
import { ModalActividadPage } from './../modal-actividad/modal-actividad';
import { HttpProvider } from './../../providers/http/http';
import { Component } from '@angular/core';
import { NavController, NavParams, ModalController } from 'ionic-angular';
import { Actividad } from '../../modelos/modelos';
import { UsuarioProvider } from '../../providers/usuario/usuario';

@Component({
  selector: 'page-actividad',
  templateUrl: 'actividad.html',
})
export class ActividadPage {

  actividades: Actividad[];
  actividadesInit: Actividad[];
  isEmpleado: boolean;
  isAlumno: boolean;
  // usuario: any;
  detalleActividadPage: any;


  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private http: HttpProvider,
    private user: UsuarioProvider,
    private modalCtrl: ModalController) {

    this.detalleActividadPage = DetalleActividadPage;
    this.validarUsuario();
  }

  validarUsuario() {

    this.getActividades();
    switch (this.user.getRol().nombre) {
      case "Docente":
        break;
      case "Alumno":
        this.isAlumno = true;
        break;
      case "Administrador":
        this.isEmpleado = true;
        break;
      default:
        break;
    }
  }

  getActividades() {
    this.http.get('actividad').then((data: any) => this.actividades = this.actividadesInit = data.data);
  }

  inicializar() {
    this.actividades = this.actividadesInit;
  }

  filtrarActividades(ev: any) {

    this.inicializar();

    const val = ev.target.value;

    if (val && val.trim() != '') {
      this.actividades = this.actividades.filter((item) => {
        return (item.nombre.toLowerCase().indexOf(val.toLowerCase()) > -1 ||
          item.detalle.toLowerCase().indexOf(val.toLowerCase()) > -1);
      });
    }
  }

  nuevaActividad() {
    const modal = this.modalCtrl.create(ModalActividadPage);
    modal.onDidDismiss(data => {
      this.getActividades();
    });
    modal.present();
  }

  editarActividad(actividad: any) {
    const modal = this.modalCtrl.create(ModalActividadPage, { actividad: actividad });
    modal.present();
  }
}
