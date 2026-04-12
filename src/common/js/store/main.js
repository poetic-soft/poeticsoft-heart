const { registerStore, select } = wp.data;

import actions from './actions/main';
import selectors from './selectors/main';
import reducer from './reducer/main';
import resolvers from './resolvers/main';
import controls from './controls/main';

const storeKey = POETICSOFT_HEART.store_key;

if (!select(storeKey)) {
    registerStore(POETICSOFT_HEART.store_key, {
        reducer,
        actions,
        selectors,
        resolvers,
        controls
    });
}
