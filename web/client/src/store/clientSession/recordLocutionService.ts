import { action, Action, Computed, computed, Thunk, thunk } from 'easy-peasy';
import axios from 'axios';
import { AppStore } from 'store';

type NullableRecordType = Record<string, string | number> | null;

interface RecordLocutionServiceState {
  loading: boolean,
  serviceEnabled: Computed<RecordLocutionServiceState, boolean>,
  recordLocutionService: NullableRecordType,
  companyRecordLocutionService: NullableRecordType,
}

interface RecordLocutionServiceActions {
  reset: Action<RecordLocutionServiceState, void>,
  setLoading: Action<RecordLocutionServiceState, void>,
  unsetLoading: Action<RecordLocutionServiceState, void>,
  setRecordLocutionService: Action<RecordLocutionServiceState, NullableRecordType>,
  setCompanyRecordLocutionService: Action<RecordLocutionServiceState, NullableRecordType>,

  load: Thunk<() => Promise<void>>,
  loadRecordLocutionService: Thunk<() => Promise<void>>,
  loadCompanyRecordLocutionService: Thunk<() => Promise<void>, number, any, AppStore>,
}

export type RecordLocutionServiceStore = RecordLocutionServiceActions & RecordLocutionServiceState;

// TODO reset after a login
const recordLocutionService: RecordLocutionServiceStore  = {
  loading: false,
  recordLocutionService: null,
  companyRecordLocutionService: null,
  serviceEnabled: computed<RecordLocutionServiceState, boolean>((state) => {
    return state.recordLocutionService !== null && state.companyRecordLocutionService !== null;
  }),
  ///////////////////////////////
  // Actions
  ///////////////////////////////
  reset: action<RecordLocutionServiceState, void>((state: any) => {
    state.loading = false;
    state.recordLocutionService = null;
    state.companyRecordLocutionService = null;
  }),
  setLoading: action<RecordLocutionServiceState, void>((state: any) => {
    state.loading = true;
  }),
  unsetLoading: action<RecordLocutionServiceState, void>((state: any) => {
    state.loading = false;
  }),
  setRecordLocutionService: action<RecordLocutionServiceState, NullableRecordType>(
    (state, recordLocutionService) => {
      state.recordLocutionService = recordLocutionService;
    }
  ),
  setCompanyRecordLocutionService: action<RecordLocutionServiceState, NullableRecordType>(
    (state, companyRecordLocutionService) => {
      state.companyRecordLocutionService = companyRecordLocutionService;
    }
  ),
  ///////////////////////////////
  // Thunks
  ///////////////////////////////
  load: thunk<RecordLocutionServiceStore>(async (actions, payload: unknown, {getState}) => {

    const state = getState();
    if (state.loading) {
      return;
    }

    actions.setLoading();
    const recordLocutionService = await actions.loadRecordLocutionService();
    if (recordLocutionService) {
      actions.loadCompanyRecordLocutionService(recordLocutionService.id)
    }
  }),
  loadRecordLocutionService: thunk<RecordLocutionServiceStore, undefined, any, AppStore>(
    async (actions, payload: undefined, {getStoreActions}) => {

      const apiGet = getStoreActions().api.get;

      const CancelToken = axios.CancelToken;
      const source = CancelToken.source();

      const resp = await apiGet({
        path: '/services',
        params: {iden: 'RecordLocution'},
        successCallback: async () => { return; },
        cancelToken: source.token
      });

      if (! resp?.data?.length) {
          return;
      }

      const recordLocutionService = resp?.data[0];
      actions.setRecordLocutionService(recordLocutionService);

      return recordLocutionService;
    }
  ),
  loadCompanyRecordLocutionService: thunk<RecordLocutionServiceStore, number, any, AppStore>(
    async (actions, payload: number, {getStoreActions}) => {

      const apiGet = getStoreActions().api.get;

      const CancelToken = axios.CancelToken;
      const source = CancelToken.source();

      const resp = await apiGet({
        path: '/company_services',
        params: {service: payload},
        successCallback: async () => { return; },
        cancelToken: source.token
      });

      if (! resp?.data?.length) {
          return;
      }

      const companyRecordLocutionService = resp?.data[0];
      actions.setCompanyRecordLocutionService(companyRecordLocutionService);

      return companyRecordLocutionService;
    }
  ),
};

export default recordLocutionService;