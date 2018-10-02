import { Injectable } from '@angular/core';
import { Usuario, Rol } from '../../modelos/modelos';

@Injectable()
export class UsuarioProvider {

  user: Usuario;
  rol: Rol;
  constructor() {

  }

  setUsuario(user: Usuario, file_curriculum:any) {
    this.user = user;
    this.user.file_curriculum=file_curriculum;
  }

  getUsuario() {
    return this.user;
  }

  setRol(rol: Rol) {
    this.rol = rol;
  }

  getRol() {
    return this.rol;
  }

}


