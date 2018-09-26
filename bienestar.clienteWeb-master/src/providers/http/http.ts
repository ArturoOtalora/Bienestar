import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable()
export class HttpProvider {

  apiUrl: string;
  httpOptions: any;

  constructor(public http: HttpClient) {

    this.apiUrl = 'http://192.168.43.243:8000/';
    this.httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Authorization': 'my-auth-token'
      })
    };
  }

  post(url: string, data: any) {
    console.log(this.apiUrl + url);
    console.log(data);
    return new Promise((resolve, reject) => {
      this.http.post(this.apiUrl + url, JSON.stringify(data), this.httpOptions)
        .subscribe(res => {
          console.log('respuesta');
          console.log(res);
          resolve(res);
        }, (err) => {
          console.log('error');
          console.log(err);
          reject(err);
        });
    });
  }

  put(url: string, data: any) {
    return new Promise((resolve, reject) => {
      this.http.put(this.apiUrl + url, JSON.stringify(data), this.httpOptions)
        .subscribe(res => {
          resolve(res);
        }, (err) => {
          console.log(err);
          reject(err);
        });
    });
  }

  get(url: string) {
  // console.log(this.apiUrl + url);
    return new Promise(resolve => {
      this.http.get(this.apiUrl + url, this.httpOptions).subscribe(data => {
       /* console.log('respuesta get');
        console.log(data);*/
        resolve(data);
      }, err => {
        console.log(err);
      });
    });
  }


}
