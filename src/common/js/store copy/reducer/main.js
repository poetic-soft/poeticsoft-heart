import { produce } from 'immer';
import defaultState from '../state';

import portals from './portals';
import dashboard from './dashboard';

export default (state = defaultState, action) => {
    return produce(state, (draft) => {
        portals(draft, action);
        dashboard(draft, action);
    });
};
