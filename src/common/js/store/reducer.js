import defaultState from './state';

export default (state = defaultState, action) => {
    switch (action.type) {
        case 'PORTAL_ADD':
            return {
                ...state,
                portals: [...state.portals, action.payload]
            };
        default:
            return state;
    }
};
