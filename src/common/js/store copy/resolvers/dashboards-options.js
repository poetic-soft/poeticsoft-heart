import actions from '../actions/main';

export default {
    *dashboardsOptionsGet() {
        const { api, store_key } = POETICSOFT_HEART;
        const { select } = wp.data;

        const state = select(store_key).dashboardsOptionsGet();
        const optionNames = Object.keys(state.options || {});

        // Si no hay claves, no disparamos la API todavía.
        // El resolver se quedará "pendiente" hasta que el estado cambie.
        if (optionNames.length > 0) {
            try {
                const response = yield api.apiClient.post('v1/options/get', {
                    optionNames: optionNames
                });

                if (response.success) {
                    yield actions.dashboardsOptionsSetValues(response.data);
                }
            } catch (e) {
                console.error('Error en hidratación:', e);
            }
        }
    }
};
