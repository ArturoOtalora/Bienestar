import { HttpProvider } from './../../providers/http/http';
import { UsuarioProvider } from './../../providers/usuario/usuario';
import { Component } from '@angular/core';
import { NavController, NavParams, ModalController } from 'ionic-angular';
import { Usuario } from '../../modelos/modelos';
import { ModalUsuario } from '../modal-usuario/modal-usuario';

@Component({
  selector: 'page-usuario',
  templateUrl: 'usuario.html',
})
export class UsuarioPage {

  segmento: string;
  docentes: any[];
  docentesinit: any[];
  administradores: any[];

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private modalCtrl: ModalController,
    private user: UsuarioProvider,
    private http: HttpProvider) {

    this.segmento = "docentes";

    this.http.get('usuario/docente').then((data: any) => {
      this.docentes = this.docentesinit = data.data;  
      console.log(this.docentes); 
    });

    this.http.get('usuario/administrador').then((data: any) => {
      this.administradores = data.data;
      console.log(this.administradores);
    });
  }

  inicializar() {
    this.docentes = this.docentesinit;
  }

  filtrarDocentes(ev: any) {
    this.inicializar();
//console.log(this.docentes );
    const val = ev.target.value;
    //console.log(val );
    if (val && val.trim() != '') {
      this.docentes = this.docentes.filter((item) => {
        return (item.correo.toLowerCase().indexOf(val.toLowerCase()) > -1 ||
          item.nombre.toLowerCase().indexOf(val.toLowerCase()) > -1);
      });
    }
  }

  filtrarAdministradores(ev: any) {

  }

  nuevoAdministrador (item: Usuario) {
   /* let modal = this.modalCtrl.create(ModalUsuario, { data: item,tipo:'Admin' });
    modal.onDidDismiss(data => {
      this.http.get('Administrador').then((data: any) => this.docentes = data.data);
    });
    modal.present();*/
  }

  nuevoDocente(item: Usuario) {

    let modal = this.modalCtrl.create(ModalUsuario, { data: item,tipo:'Docente' });
    modal.onDidDismiss(data => {
      this.http.get('usuario/docente').then((data: any) => {
        this.docentes = this.docentesinit = data.data;  
      });
    });
    modal.present();

  }



}
