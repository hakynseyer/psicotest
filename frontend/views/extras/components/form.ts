import {computed} from 'vue'
import type {ComputedRef} from 'vue'
import {TypeExtras, TypeSelectOptions, EnumGender, TypeRadioOptions, TypeTask} from '@TS/interfaces'

import { dataCityCountry } from "@TS/data/cityCountry";

import {Fetch, FETCH_METHODS} from '@Assets/ts/fetch'

import {EM} from '@Assets/ts/mitt'

declare var THE_SERVER: any;

interface FormData {
  gender: {
    data: EnumGender;
    error: string;
  };
  country: {
    data: string;
    error: string;
  };
  city: {
    data: string;
    error: string;
  };
  address: {
    data: string;
    error: string;
  };
  phone: {
    data: Array<TypeTask>;
    error: string;
  };
  map_longitude: {
    data: string;
    error: string;
  };
  map_latitude: {
    data: string;
    error: string;
  };
  user: {
    data: number;
    error: string;
  }
}

class GettersSettersClass {
  protected _form: FormData

  protected _extrasSelected: TypeExtras

  protected _radioOptions: Array<TypeRadioOptions<EnumGender>>

  protected _countryList: Array<TypeSelectOptions>
  protected _cityList: Array<TypeSelectOptions>
  protected _userList: Array<TypeSelectOptions>

  get radioOptions(): Array<TypeRadioOptions<EnumGender>> {
    return this._radioOptions;
  }

  get userList(): Array<TypeSelectOptions> {
    return this._userList;
  }

  get countryList(): Array<TypeSelectOptions> {
    return this._countryList;
  }

  get cityList(): Array<TypeSelectOptions> {
    return this._cityList;
  }

  get gender(): EnumGender {
    return this._form.gender.data;
  }
  set gender(gender: EnumGender) {
    this._form.gender.data = gender;
  }
  get genderError(): string {
    return this._form.gender.error;
  }

  get country(): string {
    return this._form.country.data;
  }
  set country(country: string) {
    this._form.country.data = country;

    if (Object.keys(dataCityCountry).includes(country)) {
      this._cityList = dataCityCountry[country].map(city => {
        return {
          label: city,
          value: city
        }
      })
    }
  }
  get countryError(): string {
    return this._form.country.error;
  }

  get city(): string {
    return this._form.city.data;
  }
  set city(city: string) {
    this._form.city.data = city;
  }
  get cityError(): string {
    return this._form.city.error;
  }

  get address(): string {
    return this._form.address.data;
  }
  set address(address: string) {
    this._form.address.data = address;
  }
  get addressError(): string {
    return this._form.address.error;
  }

  get phone(): Array<TypeTask> {
    return this._form.phone.data;
  }
  set phone(phone: Array<TypeTask>) {
    this._form.phone.data = phone
  }
  get phoneError(): string {
    return this._form.phone.error;
  }

  get map_longitude(): string {
    return this._form.map_longitude.data;
  }
  set map_longitude(map_longitude: string) {
    this._form.map_longitude.data = map_longitude;
  }
  get map_longitudeError(): string {
    return this._form.map_longitude.error;
  }

  get map_latitude(): string {
    return this._form.map_latitude.data;
  }
  set map_latitude(map_latitude: string) {
    this._form.map_latitude.data = map_latitude;
  }
  get map_latitudeError(): string {
    return this._form.map_latitude.error;
  }

  get user(): number {
    return this._form.user.data;
  }
  set user(user: number) {
    this._form.user.data = user;
  }
  get userError(): string {
    return this._form.user.error;
  }

  get extrasSelected(): TypeExtras {
    return this._extrasSelected;
  }
  set extrasSelected(extrasSelected: TypeExtras) {
    this._extrasSelected = extrasSelected;
  }

  get enableSend(): ComputedRef<boolean> {
    return computed<boolean>((): boolean => {
      const noEmpty: boolean = this._form.gender.data.length && this._form.country.data.length && this._form.city.data.length && this._form.address.data.length && this._form.user.data > 0 ? true : false

      if (noEmpty) return false

      return true
    })
  }

  get titleSend(): ComputedRef<string> {
    return computed<string>((): string => {
      if (this._extrasSelected === null) return 'Añadir Extras'
      else return "Editar Extras"
    })
  }
}

export class FormClass extends GettersSettersClass {
  constructor() {
    super()

    this.clearData()

    this._extrasSelected = null

    this._userList = null

    this._radioOptions = [
      {label:'Masculino', value:EnumGender.MALE},
      {label:'Femenino', value:EnumGender.FEMALE}
    ]
  }

  public clearData() {
    EM.emit('VIEW_EXTRAS_titleForm', 'Añadir Extras')
    
    if (this._extrasSelected !== null) this._extrasSelected = null
    
    this._form = {
      gender: {data: EnumGender.MALE, error: ''},
      country: {data: '', error: ''},
      city: {data: '', error: ''},
      address: {data: '', error: ''},
      phone: {data: [], error: ''},
      map_longitude: {data: '', error: ''},
      map_latitude: {data: '', error: ''},
      user: {data: 0, error: ''}
    }
  }

  public getCountryList(): void {
    this._countryList = Object.keys(dataCityCountry).map((country: string) => {
      return {
        label: country,
        value: country,
      };
    });
  }

  public async getUserList(): Promise<void> {
    const request: Request = Fetch.request(
      `${THE_SERVER.host}/users`,
      FETCH_METHODS.GET
    );

    try {
      const res = await fetch(request);
      const data = await res.json();

      this._userList = data.users.map(user => {
        return {
          value: user.id,
          label: `${user.name} ${user.surname_first} ${user.surname_second}`,
        };
      });

      return;
    } catch (e) {
      console.error(e);
    }

    EM.emit("COMPONENT_ALERT_launchAlert", {
      color: "danger",
      message: "Hubo un problema con el servidor",
      status: true,
    });
  }

  public async sendForm(): Promise<void> {
    EM.emit("COMPONENT_ALERT_launchAlert", {
      color: "warning",
      message: "Enviando Datos al Servidor",
      status: true
    })

    const bodyRequest = {
      gender: this._form.gender.data,
      country: this._form.country.data,
      city: this._form.city.data,
      address: this._form.address.data,
      phone: this._form.phone.data,
      map_longitude: this._form.map_longitude.data,
      map_latitude: this._form.map_latitude.data,
      user: this._form.user.data
    }

    if (this._extrasSelected !== null) bodyRequest['id'] = this._extrasSelected.id
    const request: Request = Fetch.request(
      this._extrasSelected === null ? `${THE_SERVER.host}/extras/create` : `${THE_SERVER.host}/extras/update`,
      this._extrasSelected === null ? FETCH_METHODS.POST : FETCH_METHODS.PUT,
      bodyRequest
    )

    try {
      const res = await fetch(request)

      switch (res.status) {
        case 200:
          EM.emit("COMPONENT_ALERT_launchAlert", {
            color: "success",
            message: this._extrasSelected === null ? `Añadido extras al usuario` : `Actualizado extras del usuario`,
            status: true,
            timer: 5000
          })

          // Actualizar Tabla
          EM.emit("VIEW_EXTRAS_updateTable")

          // Limpiar Datos
          this.clearData()

          return
          break
        case 406:
          const data = await res.json()

          Object.keys(this._form).forEach(key => {
            if (data.error[key] !== null && data.error[key] !== undefined) this._form[key].error = data.error[key]
          })

          EM.emit("COMPONENT_ALERT_launchAlert", {status: false})
          return
          break
      }
    } catch (e) {
      console.error(e)

      EM.emit("COMPONENT_ALERT_launchAlert", {
        color: "danger",
        message: "Hubo un problema con el servidor",
        status: true
      })
    }
  }
}
