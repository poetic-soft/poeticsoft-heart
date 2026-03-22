const { registerStore } = wp.data;
import actions from './actions/main';
import selectors from './selectors/main';
import reducer from './reducer/main';
import resolvers from './resolvers/main';

registerStore(POETICSOFT_HEART.store_key, {
    reducer,
    actions,
    selectors,
    resolvers
});
