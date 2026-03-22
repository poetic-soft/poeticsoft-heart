import actions from 'common/js/store/actions/main';

export default {
    *dashboardsOptionGet(optionName) {
        const { api, store_key } = POETICSOFT_HEART;

        try {
            actions.dashboardsOptionSetStatus({
                optionName: optionName,
                status: 'updating'
            });

            const response = yield api.apiClient.post('v1/option/get', {
                option_name: optionName
            });

            if (response.success) {
                yield actions.dashboardsOptionSetValue(response.data);
            }
        } catch (e) {
            console.error('Error en hidratación:', e);
        }
    }
};
