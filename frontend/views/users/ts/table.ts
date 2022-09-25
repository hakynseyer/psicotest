import { EM } from "@Assets/ts/mitt";
import { Fetch, FETCH_METHODS } from "@Assets/ts/fetch";
import { TypeTableHeader, TypeUser } from "@TS/interfaces";

declare var THE_SERVER: any;

class GettersSettersClass {
  protected _headers: Array<TypeTableHeader>;
  protected _users: Array<TypeUser>;

  protected _originUsers: Array<TypeUser>;

  get headers(): Array<TypeTableHeader> {
    return this._headers;
  }

  get users(): Array<TypeUser> {
    return this._users;
  }
  set users(users: Array<TypeUser>) {
    this._users = users;
  }
}

export class TableClass extends GettersSettersClass {
  constructor() {
    super()

    this._headers = [
      {
        label: "Nombre",
        link: "name",
      },
      {
        label: "Apellido Paterno",
        link: "surname_first",
      },
      {
        label: "Apellido Materno",
        link: "surname_second"
      },
      {
        label: "Rango",
        link: "rankName"
      },
      {
        label: "Contraseña",
        link: "password"
      },
    ];

    this._users = [];
    this._originUsers = [];
  }


  public saveUserSelected(user: TypeUser) {
    EM.emit("VIEW_USERS_FORM_userSelected", user);
    EM.emit("VIEW_USERS_titleForm", "Editar Usuario");
  }

  public deleteUserSelected(user: TypeUser) {
    EM.emit("VIEW_USERS_FORM_deleteUser", user);
  }

  public searchUser(search: string) {
    const searchFix = search.toLowerCase();

    this._users = this._originUsers.filter((user: TypeUser) => {
      return (
        user.name.toLowerCase().match(searchFix) ||
        user.surname_first.toLowerCase().match(searchFix) ||
        user.surname_second.toLowerCase().match(searchFix) ||
        user.rankName.toLowerCase().match(searchFix)
      );
    });
  }

  public async listUsers(): Promise<void> {
    const request: Request = Fetch.request(
      `${THE_SERVER.host}/users`,
      FETCH_METHODS.GET
    );

    try {
      const res = await fetch(request);
      const data = await res.json();

      const users: Array<TypeUser> = data.users.map((user: TypeUser) => {
        return {
          id: user.id,
          name: user.name,
          surname_first: user.surname_first,
          surname_second: user.surname_second,
          password: user.password,
          notes: user.notes,
          rank: user.rank,
          rankName: user.rankName
        };
      });

      this._originUsers = users;
      this._users = users;

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
