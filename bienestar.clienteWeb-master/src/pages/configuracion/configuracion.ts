import { ModalTipoActividadPage } from './../modal-tipo-actividad/modal-tipo-actividad';
import { ModalCarreraPage } from './../modal-carrera/modal-carrera';
import { ModalFacultadPage } from './../modal-facultad/modal-facultad';
import { ModalEmpresaPage } from './../modal-empresa/modal-empresa';
import { UsuarioProvider } from './../../providers/usuario/usuario';
import { HttpProvider } from './../../providers/http/http';
import { Component } from '@angular/core';
import { NavController, NavParams, ToastController, ModalController } from 'ionic-angular';
import { Empresa, Facultad, TipoActividad, Carrera, Rol, Alumno } from '../../modelos/modelos';

@Component({
  selector: 'page-configuracion',
  templateUrl: 'configuracion.html',
})
export class ConfiguracionPage {

  empresas: Empresa[];
  facultades: Facultad[];
  carreras: Carrera[];
  tiposActividad: TipoActividad[];

  rol: Rol;
  segmento: any;
  isAdmin: boolean;
  isAlumno: boolean;
  hv:any;
  alumno:Alumno;


  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private http: HttpProvider,
    private toastCtrl: ToastController,
    private modalCtrl: ModalController,
    private user: UsuarioProvider) {
      this.alumno=new Alumno();
      
    this.validarUsuario();
    this.cargarData();

  }

  cargarData() {

    this.http.get('empresa').then((data: any) => this.empresas = data.data);
    this.http.get('facultad').then((data: any) => this.facultades = data.data);
    this.http.get('carrera').then((data: any) => this.carreras = data.data);
    this.http.get('tipo_actividad').then((data: any) => this.tiposActividad = data.data);

  }

  guardarEmpresa(item: Empresa) {
    let modal = this.modalCtrl.create(ModalEmpresaPage, { data: item });
    modal.onDidDismiss(data => {
      this.http.get('empresa').then((data: any) => this.empresas = data.data);
    });
    modal.present();
  }

  guardarFacultad(item: Facultad) {
    let modal = this.modalCtrl.create(ModalFacultadPage, { data: item });
    modal.onDidDismiss(data => {
      this.http.get('facultad').then((data: any) => this.facultades = data.data);
    });
    modal.present();
  }

  guardarCarrera(item: Carrera) {
    let modal = this.modalCtrl.create(ModalCarreraPage, { data: item });
    modal.onDidDismiss(data => {
      this.http.get('carrera').then((data: any) => this.carreras = data.data);
    });
    modal.present();
  }

  guardarTipoActividad(item: TipoActividad) {
    let modal = this.modalCtrl.create(ModalTipoActividadPage, { data: item });
    modal.onDidDismiss(data => {
      this.http.get('tipo_actividad').then((data: any) => this.tiposActividad = data.data);
    });
    modal.present();
  }

  validarUsuario() {
    this.rol = this.user.getRol();
    if (this.rol.nombre === 'Administrador') {
      this.isAdmin = true;
      this.segmento = 'empresa';
    }
    if (this.rol.nombre === 'Alumno') {
      this.isAlumno = true;
      this.segmento = 'perfil';
      this.getAlumno();
    }
  }

  getAlumno(){
    this.http.get('usuario/alumno/' + this.user.getUsuario().id).then((data: any) => {
      this.alumno = data.data
    });
  }

  ActualizarHVAlumno(){
    console.log(this.alumno);
    this.http.put('usuario/alumno/' + this.alumno.id, this.alumno).then((data: any) => {
      this.user.user.file_curriculum= this.alumno.file_curriculum;
      let toast = this.toastCtrl.create({
        message: 'Hoja de vida actualizada con éxito',
        duration: 1500
      });
      toast.present();
      this.getAlumno();
    });

  }

  subirHV($event) {
    var file: File = $event.target.files[0];
    var myReader: FileReader = new FileReader();
    myReader.onloadend = (e) => {
      if(file.type==='application/pdf'){
        this.alumno.file_curriculum = myReader.result;
      } 
      else{
        let toast = this.toastCtrl.create({
          message: 'Tipo de archivo invalido',
          duration: 1500
        });
        toast.present();
      }
    }
    myReader.readAsDataURL(file);
  }

  convertir(archivo) {
 console.log(archivo);
    const linkSource = archivo;
    const downloadLink = document.createElement("a");
    const fileName = "hv_"+this.user.user.nombre+"_"+this.user.user.documento+".pdf";

    downloadLink.href = linkSource;
    downloadLink.download = fileName;
    downloadLink.click();
  }

}
