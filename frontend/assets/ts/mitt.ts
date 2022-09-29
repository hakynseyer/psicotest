import mitt, { Emitter } from "mitt";
import {
  TypeAlertData,
  TypeUser,
  TypeExtras,
  TypeExtrasMap,
  TypeRank,
} from "@TS/interfaces";

type Events = {
  APP_h1: string;

  COMPONENT_ALERT_launchAlert: TypeAlertData;

  VIEW_RANKS_titleForm: string;
  VIEW_RANKS_FORM_rankSelected: TypeRank;
  VIEW_RANKS_FORM_deleteRank: TypeRank;
  VIEW_RANKS_updateTable: void;

  VIEW_USERS_titleForm: string;
  VIEW_USERS_FORM_userSelected: TypeUser;
  VIEW_USERS_FORM_deleteUser: TypeUser;
  VIEW_USERS_updateTable: void;

  VIEW_EXTRAS_titleForm: string;
  VIEW_EXTRAS_FORM_extrasSelected: TypeExtras;
  VIEW_EXTRAS_FORM_deleteExtras: TypeExtras;
  VIEW_EXTRAS_updateTable: void;
  VIEW_EXTRAS_mapLeaflet: TypeExtrasMap;
};

export const EM: Emitter<Events> = mitt<Events>();
