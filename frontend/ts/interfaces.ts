export interface TypeAlertData {
  color?: string;
  status?: boolean;
  message?: string;
  timer?: number;
}

export interface TypeSelectOptions {
  label: string;
  value: string;
}

export interface TypeRadioOptions<T> {
  label: string;
  value: T;
}

export interface TypeTask {
  title: string;
  value: string;
}

export interface TypeTableHeader {
  label: string;
  link: string;
}

export type TypeRank = {
  id: number;
  rank: string;
  description: string;
};

export type TypeUser = {
  id: number;
  name: string;
  surname_first: string;
  surname_second: string;
  password: string;
  notes: string;
  rank: number;
  rankName: string;
};

export enum EnumGender {
  MALE = 'male',
  FEMALE = 'female'
}

export type TypeExtras = {
  id: number;
  gender: EnumGender;
  country: string;
  city: string;
  address: string;
  phone: Array<TypeTask>;
  map_longitude: string;
  map_latitude: string;
  user: number;
  name: string;
  surname_first: string;
  surname_second: string;
  genderHeader: string;
  userName: string;
}
