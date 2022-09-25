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

export interface TypeTableHeader {
  label: string;
  link: string;
}

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

export type TypeRank = {
  id: number;
  rank: string;
  description: string;
};
