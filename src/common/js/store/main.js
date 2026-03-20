const { registerStore } = wp.data;
import config from 'common/js/config';
import actions from './actions';
import selectors from './selectors';
import reducer from './reducer';

const store = registerStore(config.store_key, {
    reducer,
    actions,
    selectors
});
