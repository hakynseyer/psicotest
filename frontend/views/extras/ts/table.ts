import { EM } from "@Assets/ts/mitt";
import { Fetch, FETCH_METHODS } from "@Assets/ts/fetch";
import { TypeTableHeader, TypeExtras } from "@TS/interfaces";

declare var THE_SERVER: any;

class GettersSettersClass {
  protected _headers: Array<TypeTableHeader>;
  protected _extras: Array<TypeExtras>;

  protected _originExtras: Array<TypeExtras>;

  get headers(): Array<TypeTableHeader> {
    return this._headers;
  }

  get extras(): Array<TypeExtras> {
    return this._extras;
  }
  set extras(extras: Array<TypeExtras>) {
    this._extras = extras;
  }
}

export class TableClass extends GettersSettersClass {
  constructor() {
    super()

    this._headers = [
      {
        label: "Usuario",
        link: "userName",
      },
      {
        label: "Genero",
        link: "genderHeader",
      },
      {
        label: "Estado",
        link: "country"
      },
      {
        label: "Municipio",
        link: "city"
      },
      {
        label: "Direccion",
        link: "address"
      },
    ];

    this._extras = [];
    this._originExtras = [];
  }


  public saveExtraSelected(extra: TypeExtras) {
    EM.emit("VIEW_EXTRAS_FORM_extrasSelected", extra);
    EM.emit("VIEW_EXTRAS_titleForm", "Editar Usuario");
  }

  public deleteExtraSelected(extra: TypeExtras) {
    EM.emit("VIEW_EXTRAS_FORM_deleteExtras", extra);
  }

  public searchExtra(search: string) {
    const searchFix = search.toLowerCase();

    this._extras = this._originExtras.filter((extra: TypeExtras) => {
      return (
        extra.genderHeader.toLowerCase().match(searchFix) ||
        extra.country.toLowerCase().match(searchFix) ||
        extra.city.toLowerCase().match(searchFix) ||
        extra.userName.toLowerCase().match(searchFix)
      );
    });
  }

  public async listExtras(): Promise<void> {
    const request: Request = Fetch.request(
      `${THE_SERVER.host}/extras`,
      FETCH_METHODS.GET
    );

    try {
      const res = await fetch(request);
      const data = await res.json();

      const extras: Array<TypeExtras> = data.extras.map((extra: TypeExtras) => {
        return {
          id: extra.id,
          gender: extra.gender,
          genderHeader: extra.gender === 'male' ? 'Masculino' : 'Femenino',
          country: extra.country,
          city: extra.city,
          address: extra.address,
          phone: extra.phone,
          user: extra.user,
          userName: `${extra.name} ${extra.surname_first} ${extra.surname_second}`
        };
      });

      this._originExtras = extras;
      this._extras = extras;

      return;
    } catch (e) {
      console.error(e);
    }

    EM.emit("COMPONENT_ALERT_launchAlert", {
      color: "danger",
      message: "Hubo un problema con el servidor",
      status: true,
    });

    return;
  }
}
