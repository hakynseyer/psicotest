import { computed } from "vue";
import type { ComputedRef } from "vue";
import { TypeUser, TypeSelectOptions } from "@TS/interfaces";

import { Fetch, FETCH_METHODS } from "@Assets/ts/fetch";

import { EM } from "@Assets/ts/mitt";

declare var THE_SERVER: any;

interface FormData {
  name: {
    data: string;
    error: string;
  };
  surname_first: {
    data: string;
    error: string;
  };
  surname_second: {
    data: string;
    error: string;
  };
  password: {
    data: string;
    error: string;
  };
  notes: {
    data: string;
    error: string;
  };
  rank: {
    data: number;
    error: string;
  };
}

class GettersSettersClass {
  protected _form: FormData;

  protected _userSelected: TypeUser;

  protected _rankList: Array<TypeSelectOptions>

  get rankList(): Array<TypeSelectOptions> {
    return this._rankList;
  }

  get name(): string {
    return this._form.name.data;
  }
  set name(name: string) {
    this._form.name.data = name;
  }
  get nameError(): string {
    return this._form.name.error;
  }

  get surname_first(): string {
    return this._form.surname_first.data;
  }
  set surname_first(surname_first: string) {
    this._form.surname_first.data = surname_first;
  }
  get surname_firstError(): string {
    return this._form.surname_first.error;
  }

  get surname_second(): string {
    return this._form.surname_second.data;
  }
  set surname_second(surname_second: string) {
    this._form.surname_second.data = surname_second;
  }
  get surname_secondError(): string {
    return this._form.surname_second.error;
  }

  get password(): string {
    return this._form.password.data;
  }
  set password(password: string) {
    this._form.password.data = password;
  }
  get passwordError(): string {
    return this._form.password.error;
  }

  get notes(): string {
    return this._form.notes.data;
  }
  set notes(notes: string) {
    this._form.notes.data = notes;
  }
  get notesError(): string {
    return this._form.notes.error;
  }

  get rank(): number {
    return this._form.rank.data;
  }
  set rank(rank: number) {
    this._form.rank.data = rank;
  }
  get rankError(): string {
    return this._form.rank.error;
  }

  get userSelected(): TypeUser {
    return this._userSelected;
  }
  set userSelected(userSelected: TypeUser) {
    this._userSelected = userSelected
  }

  get enableSend(): ComputedRef<boolean> {
    return computed<boolean>((): boolean => {
      const noEmpty: boolean = this._form.name.data.length && this._form.surname_first.data.length && this._form.surname_second.data.length && this._form.password.data.length && this._form.rank.data > 0 ? true: false;

      if (noEmpty) return false

      return true
    });
  }

  get titleSend(): ComputedRef<string> {
    return computed<string>((): string => {
      if (this._userSelected === null) return "Crear Usuario"
      else return "Editar Usuario"
    })
  }
}

export class FormClass extends GettersSettersClass {

  constructor() {
    super();

    this.clearData();

    this._userSelected = null;

    this._rankList = null;
  }

  public clearData() {
    EM.emit("VIEW_USERS_titleForm", "Nuevo Usuario");

    if (this._userSelected !== null) this._userSelected = null;

    this._form = {
      name: { data: "", error: "" },
      surname_first: { data: "", error: "" },
      surname_second: { data: "", error: "" },
      password: { data: "", error: "" },
      notes: { data: "", error: "" },
      rank: { data: 0, error: "" },
    };
  }

  public async getRankList(): Promise<void> {
    const request: Request = Fetch.request(
      `${THE_SERVER.host}/ranks`,
      FETCH_METHODS.GET
    );

    try {
      const res = await fetch(request);
      const data = await res.json();

      this._rankList = data.ranks.map((rank) => {
        return {
          value: rank.id,
          label: rank.rank,
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
      name: this._form.name.data,
      surname_first: this._form.surname_first.data,
      surname_second: this._form.surname_second.data,
      password: this._form.password.data,
      notes: this._form.notes.data,
      rank: this._form.rank.data
    }

    if (this._userSelected !== null) bodyRequest['id'] = this._userSelected.id

    const request: Request = Fetch.request(
      this._userSelected === null ? `${THE_SERVER.host}/users/create` : `${THE_SERVER.host}/users/update`,
      this._userSelected === null ? FETCH_METHODS.POST : FETCH_METHODS.PUT,
      bodyRequest
    )

    try {
      const res = await fetch(request)
      const data = await res.json()

      switch (res.status) {
        case 201:
          EM.emit("COMPONENT_ALERT_launchAlert", {
            color: "success",
            message: this._userSelected === null ? `Usuario ${data.name} ${data.surname_first} creado` : `Usuario ${data.name} ${data.surname_first} actualizado`,
            status: true,
            timer: 5000
          })

          // Actualizar Tabla
          EM.emit("VIEW_USERS_updateTable")

          // Limpiar Datos
          this.clearData()

          return
          break
        case 406:
          Object.keys(this._form).forEach(key=> {
            if (data.error[key] !== null && data.error[key] !== undefined)
              this._form[key].error = data.error[key]
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

  public async deleteUser(user: TypeUser): Promise<void> {
    this.clearData()

    const request: Request = Fetch.request(
      `${THE_SERVER.host}/users/delete`,
      FETCH_METHODS.DELETE,
      {
        id: user.id,
      }
    );

    try {
      const res = await fetch(request);

      switch (res.status) {
        case 200:
          EM.emit("COMPONENT_ALERT_launchAlert", {
            color: "success",
            message: `Usuario ${user.name} ${user.surname_first} eliminado`,
            status: true,
            timer: 5000,
          });

          // Actualizar Tabla
          EM.emit("VIEW_USERS_updateTable");

          return;
          break;
      }
    } catch (e) {
      console.error(e);

      EM.emit("COMPONENT_ALERT_launchAlert", {
        color: "danger",
        message: "Hubo un problema con el servidor",
        status: true,
      });
    }
  }
}
