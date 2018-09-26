import { UsuarioProvider } from './../../providers/usuario/usuario';
import { HttpProvider } from './../../providers/http/http';
import { Component } from '@angular/core';
import { NavController, NavParams, ModalController, Toast, ToastController } from 'ionic-angular';
import { Diplomado } from '../../modelos/modelos';
import { ModalDiplomadoPage } from '../modal-diplomado/modal-diplomado';

@Component({
  selector: 'page-diplomado',
  templateUrl: 'diplomado.html',
})
export class DiplomadoPage {

  searchQuery: string = '';
  isEmpleado: boolean;
  isAlumno: boolean;
  segmento: any;


  diplomados: Diplomado[];
  diplomadosInit: Diplomado[];

  inscritos: Diplomado[];

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private modalCtrl: ModalController,
    private toastCtrl: ToastController,
    private http: HttpProvider,
    private user: UsuarioProvider) {

    this.segmento = "diplomados";
    this.validarUsuario();
  }

  getDiplomados() {
    this.http.get('diplomado').then((data: any) => {
      if (data.data) {
        //console.log(data.data);
      this.diplomados = this.diplomadosInit = data.data
      //console.log(this.diplomados);
      this.getInscritos();
      }
    });
  }

  getInscritos() {
    this.http.get('diplomado/inscrito').then((info: any) => {   
      if (this.diplomados) {
      this.inscritos = info.data;
      this.validarAplicacion();
      }
    });
  }

  validarUsuario() {
    this.getDiplomados();
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

  inicializar() {
    this.diplomados = this.diplomadosInit;
  }

  filtrarDiplomados(ev: any) {

    this.inicializar();

    const val = ev.target.value;

    if (val && val.trim() != '') {
      this.diplomados = this.diplomados.filter((item) => {
        return (item.nombre.toLowerCase().indexOf(val.toLowerCase()) > -1 ||
          item.facultad_nombre.toLowerCase().indexOf(val.toLowerCase()) > -1);
      });
    }
  }

  nuevoDiplomado() {
    const modal = this.modalCtrl.create(ModalDiplomadoPage);
    modal.onDidDismiss(data => {
      this.getDiplomados();
    });
    modal.present();
  }

  editarDiplomado(diplomado: any) {
    const modal = this.modalCtrl.create(ModalDiplomadoPage, { diplomado: diplomado });
    modal.present();
  }

  aplicarDiplomado(diplomado: any) {

    this.http.post('diplomado/inscribe/' + diplomado.id, { id: this.user.getUsuario().id }).then((data: any) => {
      if(data.estado){
      this.validarUsuario();
      }
      else {
        let toast = this.toastCtrl.create({
          message: 'Error inscribiendose',
          duration: 1500,
          position: 'top'
        });
        toast.present();
      }
    })
  }

  validarAplicacion() {  
    for (let k = 0; k < this.diplomados.length; k++) {
        for (let i = 0; i < this.inscritos.length; i++) {    
            if(this.diplomados[k].id===this.inscritos[i].id){
              for (let j = 0; j < this.inscritos[i].alumnos.length; j++) {
                if (this.inscritos[i].alumnos[j].usuario_id === this.user.getUsuario().id) {
                  this.diplomados[k].inscrito = true;
                }
              }
          }
        }
      }
  }
}
