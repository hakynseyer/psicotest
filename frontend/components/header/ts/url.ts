import { ref } from 'vue';
import { router } from '@Assets/ts/router';
import { useStore } from '@Assets/ts/store';

interface URL {
  name: string;
  path: string;
}

export class UrlClass {
  private _urls: Array<URL> = [];

  constructor() {
    this._urls.push(this.url_ranks());
    this._urls.push(this.url_users());
    this._urls.push(this.url_extras());
  }

  get urls(): Array<URL> {
    return this._urls;
  }

  private url_ranks(): URL {
    return { name: 'ranks', path: '/' };
  }

  private url_users(): URL {
    return {name: 'users', path: '/usuarios'};
  }

  private url_extras(): URL {
    return {name: 'extras', path: '/usuarios/extras'};
  }

  public sendToHome(): void {
    const { path } = this.url_ranks();

    router.push(path);
  }
}
