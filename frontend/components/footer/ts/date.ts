import { ref, computed } from 'vue';
import type { ComputedRef } from 'vue';

enum Month {
  Enero,
  Febrero,
  Marzo,
  Abril,
  Mayo,
  Junio,
  Julio,
  Agosto,
  Septiembre,
  Octubre,
  Noviembre,
  Diciembre,
}

export class DateClass {
  private _date: Date;

  constructor() {
    this._date = new Date();
  }

  get currentDate(): ComputedRef<string> {
    return computed<string>((): string => {
      const dd: string = this.getDay();
      const mm: string = Month[this.getMonth()];
      const yy: string = this.getYear().toString();

      return `${dd} de ${mm} del ${yy}`;
    });
  }

  public getDay(): string {
    return String(this._date.getDate()).padStart(2, '0');
  }

  public getMonth(): number {
    return this._date.getMonth();
  }

  public getYear(): number {
    return this._date.getUTCFullYear();
  }
}
