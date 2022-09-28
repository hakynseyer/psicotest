import {TypeExtras, EnumGender} from '@TS/interfaces'


class GettersSettersClass {
  protected _extra: TypeExtras

  get extra(): TypeExtras {
    return this._extra;
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
  }

  setExtra(extra: TypeExtras) {
    this._extra = extra
  }
}
