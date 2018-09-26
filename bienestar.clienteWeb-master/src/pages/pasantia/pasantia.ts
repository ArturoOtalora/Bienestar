import { HttpProvider } from './../../providers/http/http';
import { UsuarioProvider } from './../../providers/usuario/usuario';
import { Component } from '@angular/core';
import { NavController, NavParams, ToastController } from 'ionic-angular';
import { Pasantia, Empresa } from '../../modelos/modelos';

@Component({
  selector: 'page-pasantia',
  templateUrl: 'pasantia.html',
})
export class PasantiaPage {

  segmento: any;
  pasantiaAlumno: Pasantia;
  pasantiaReg: Pasantia;
  empresas: Empresa[];
  pasantias: Pasantia[];
  isEmpleado: boolean;
  isAlumno: boolean;

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    private user: UsuarioProvider,
    private http: HttpProvider,
    private toastCtrl: ToastController) {

    this.pasantiaAlumno = new Pasantia();
    this.pasantiaReg = new Pasantia();
    this.validarUsuario();
    this.getEmpresas();
  }

  getPasantiaAlumno() {
    this.http.get('pasantia/' + this.user.getUsuario().id).then((data: any) => {
      this.pasantiaAlumno = data.data
    });
  }

  getPasantias() {
    this.http.get('pasantia').then((data: any) => {
      this.pasantias = data.data
    });
  }

  getEmpresas() {
    this.http.get('empresa').then((data: any) => this.empresas = data.data);
  }

  validarUsuario() {

    switch (this.user.getRol().nombre) {
      case "Docente":
        break;
      case "Alumno":
        this.isAlumno = true;
        this.segmento = 'regPasantia';
        this.getPasantiaAlumno();
        break;
      case "Administrador":
        this.isEmpleado = true;
        this.segmento = 'pasantiasReg';
        this.getPasantias();
        break;
      default:
        break;
    }
  }

  subirCarta($event) {
    var file: File = $event.target.files[0];
    var myReader: FileReader = new FileReader();
    myReader.onloadend = (e) => {
      this.pasantiaReg.file_carta = myReader.result;
    }
    myReader.readAsDataURL(file);
  }
  subirEvaluacion($event) {
    var file: File = $event.target.files[0];
    var myReader: FileReader = new FileReader();
    myReader.onloadend = (e) => {
      this.pasantiaReg.file_evaluacion = myReader.result;
    }
    myReader.readAsDataURL(file);
  }
  subirCertificado($event) {
    var file: File = $event.target.files[0];
    var myReader: FileReader = new FileReader();
    myReader.onloadend = (e) => {
      this.pasantiaReg.file_certificado = myReader.result;
    }
    myReader.readAsDataURL(file);
  }

  subirPasantia() {
    if (!this.pasantiaReg.file_carta || !this.pasantiaReg.file_certificado || !this.pasantiaReg.file_evaluacion) {
      let toast = this.toastCtrl.create({
        message: 'Hay campos vacíos',
        duration: 1500
      });
      toast.present();
    }
    else {
      this.pasantiaReg.alumno_id = this.user.getUsuario().id;
      this.http.post('pasantia', this.pasantiaReg).then((data: any) => {
        if (data.mensaje) {
          console.log(data.data);
        }
        else {

          let toast = this.toastCtrl.create({
            message: 'Registro realizado con éxito',
            duration: 1500
          });
          toast.present();
          this.getPasantiaAlumno();
        }
      });
    }
  }

  convertir(archivo) {

    var blob = new Blob([archivo]);
    var a = window.document.createElement("a");
    a.href = window.URL.createObjectURL(blob);
    a.download = "filename.pdf";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }

  guardar(pasantia: Pasantia) {
    this.http.put('pasantia/' + pasantia.id, pasantia).then((data: any) => {

      let toast = this.toastCtrl.create({
        message: 'Pasantía aprobada con éxito',
        duration: 1500
      });
      toast.present();
      this.getPasantias();
    });

  }
  aprobar(pasantia: Pasantia) {

    pasantia.estado = !pasantia.estado;
    this.guardar(pasantia);

  }
}
