class GettersSettersClass {
  protected _titleForm: string

  get titleForm(): string {
    return this._titleForm
  }
  set titleForm(titleForm: string) {
    this._titleForm = titleForm
  }
}

export class ExtrasClass extends GettersSettersClass {
  constructor() {
    super()

    this._titleForm = "Añadiendo Extras"
  }
}
