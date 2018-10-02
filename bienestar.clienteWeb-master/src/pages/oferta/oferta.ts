import { UsuarioProvider } from './../../providers/usuario/usuario';
import { Oferta, Rol, Alumno } from '../../modelos/modelos';
import { ModalOfertaPage } from '../modal-oferta/modal-oferta';
import { HttpProvider } from '../../providers/http/http';
import { Component, ViewChild } from '@angular/core';
import { NavController, NavParams, ModalController, ToastController, Nav } from 'ionic-angular';
import { ConfiguracionPage } from '../configuracion/configuracion';

@Component({
  selector: 'page-oferta',
  templateUrl: 'oferta.html',
})


export class OfertaPage {

  searchQuery: string = '';
  ofertas: Oferta[];
  ofertasInit: Oferta[];
  rol: Rol;
  isAdmin: boolean;
  isDocente: boolean;
  isAlumno: boolean;
  isAlumnoHV: boolean;
  segmento: any;
  nombreBoton: string;
  misOfertas: Oferta[];
  aplicadas: Oferta[];
  aplicadasInit: Oferta[];
  alumno:Alumno;


  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private http: HttpProvider,
    private modalCtrl: ModalController,
    private user: UsuarioProvider, private toastCtrl: ToastController) {
    this.alumno=new Alumno();
    this.nombreBoton = 'Aplicar'
    this.segmento = "ofertas";
    this.validarUsuario();

  }

  getOfertas() {

    this.http.get('oferta').then((data: any) => {
      if (data.estado) {
        this.ofertas = this.ofertasInit = data.data;
        this.getMisOfertas();
      }
    });
  }

  getMisOfertas() {
    this.http.get('oferta/' + this.user.getUsuario().id).then((data: any) => {
      if (data.estado) {
        this.misOfertas = data.data;
        this.validarAplicacion();
      }
    });
  }

  getAplicadas() {
    this.http.get('oferta/aplicada').then((data: any) => {
      if (data.estado) {
        this.aplicadas = this.aplicadasInit = data.data;
      }
    });
  }

  nuevaOferta() {
    const modal = this.modalCtrl.create(ModalOfertaPage);
    modal.onDidDismiss(data => {
      this.getOfertas();
    });
    modal.present();
  }

  editarOferta(oferta: any) {
    const modal = this.modalCtrl.create(ModalOfertaPage, { oferta: oferta });
    modal.present();
  }

  aplicarOferta(oferta: Oferta) {
    this.http.post('oferta/aplica/' + oferta.id, { id: this.user.getUsuario().id }).then((data: any) => {
      
      this.validarUsuario();
    })
  }

  validarUsuario() {
    this.rol = this.user.getRol();
    this.getOfertas();
    this.getAplicadas();

    if (this.rol.nombre === 'Administrador') {
      this.isAdmin = true;
    }
    if (this.rol.nombre === 'Alumno') {
      this.isAlumno = true;
      console.log(this.user.user.file_curriculum);
      if (this.user.user.file_curriculum === null){
        let toast = this.toastCtrl.create({
          message: 'Debe adjuntar Hoja de vida en la opción de configuración',
          duration: 15000
        });
        toast.present();         
      }
      else{
        this.isAlumnoHV=true;
      }
    }
    if (this.rol.nombre === 'Docente') {
      this.isDocente = true;
    }

  }
  

  inicializar() {
    this.ofertas = this.ofertasInit;
  }
  inicializarAplicadas() {
    this.aplicadas = this.aplicadasInit;
  }

  filtrarOfertas(ev: any) {

    this.inicializar();

    const val = ev.target.value;
    if (val && val.trim() != '') {
      this.ofertas = this.ofertas.filter((item) => {
        return (item.titulo.toLowerCase().indexOf(val.toLowerCase()) > -1 ||
          item.detalle.toLowerCase().indexOf(val.toLowerCase()) > -1 ||
          item.contacto.toLowerCase().indexOf(val.toLowerCase()) > -1 ||
          item.empresa_nombre.toLowerCase().indexOf(val.toLowerCase()) > -1);
      });
    }
  }

  filtrarOfertasAplicadas(ev: any) {

    this.inicializarAplicadas();

    const val = ev.target.value;

    if (val && val.trim() != '') {
      this.aplicadas = this.aplicadas.filter((item) => {
        return (item.titulo.toLowerCase().indexOf(val.toLowerCase()) > -1 ||
          item.detalle.toLowerCase().indexOf(val.toLowerCase()) > -1 ||
          item.contacto.toLowerCase().indexOf(val.toLowerCase()) > -1);
      });
    }
  }

  validarAplicacion() {
 //console.log(this.ofertas);
    for (let i = 0; i < this.ofertas.length; i++) {
      for (let j = 0; j < this.misOfertas.length; j++) {
        if (this.ofertas[i].id === this.misOfertas[j].id) {
          this.ofertas[i].aplicado = true;
        }
      }
    }
  }
  
  convertir(archivo) {
     const linkSource = archivo;
     const downloadLink = document.createElement("a");
     const fileName = "hv_"+this.user.user.nombre+"_"+this.user.user.documento+".pdf";
 
     downloadLink.href = linkSource;
     downloadLink.download = fileName;
     downloadLink.click();  
   } 

}
