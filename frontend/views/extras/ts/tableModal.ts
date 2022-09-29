import {TypeExtrasMap, TypeExtras, EnumGender} from '@TS/interfaces'

import {Fetch, FETCH_METHODS} from '@Assets/ts/fetch'

import {EM} from '@Assets/ts/mitt'

declare var THE_SERVER: any;

class GettersSettersClass {
  protected _extra: TypeExtras

  protected _button: string

  get extra(): TypeExtras {
    return this._extra;
  }

  get button(): string {
    return this._button;
  }
}

export class TableModalClass extends GettersSettersClass {
  constructor () {
    super()

    this._extra ??= {
      id: 0,
      user: 0,
      genderHeader: '',
      gender: EnumGender.MALE,
      country: '',
      city: '',
      name: '',
      surname_first: '',
      surname_second: '',
      userName: '',
      address: '',
      phone: [],
      map_longitude: '',
      map_latitude: ''
    }

    this._button = 'Agregar'
  }

  public async setExtra(extra: TypeExtras): Promise<void> {
    this._extra = extra

    const request: Request = Fetch.request(
      `${THE_SERVER.host}/extras/map/${this._extra.id}`,
      FETCH_METHODS.GET,
    );

    try {
      const res = await fetch(request)
      const data = await res.json()

      if (data.extras.length === 1) {
        const {map_longitude, map_latitude} = data.extras[0]

        if (map_latitude.length && map_longitude.length) this._button = 'Actualizar'
        
        EM.emit('VIEW_EXTRAS_mapLeaflet', {
          country: this._extra.country,
          city: this._extra.city,
          map_longitude,
          map_latitude
        });
      }
    } catch (e) {
      console.error(e)
    }
  }

  public async modifyMap(lat: number, lng: number): Promise<boolean> {
    const request: Request = Fetch.request(
      `${THE_SERVER.host}/extras/update/map`,
      FETCH_METHODS.PATCH,
      {
        map_longitude: lng,
        map_latitude: lat,
        id: this._extra.id
      }
    );

    try {
      const res = await fetch(request)

      if (res.status === 200) return Promise.resolve(true)
    } catch (e) {
      console.error(e)
    }

    return Promise.resolve(false)
  }
}
