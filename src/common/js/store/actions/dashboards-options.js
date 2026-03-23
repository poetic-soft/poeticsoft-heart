import actions from 'common/js/store/actions/main';

export default {
    dashboardsOptionSet(data) {
        return {
            type: 'DASHBOARD_OPTION_SET',
            payload: data
        };
    },
    *dashboardsOptionLoadValue(data) {
        try {
            yield actions.dashboardsOptionSetStatus({
                option_name: data.option_name,
                status: 'loading'
            });
            const response = yield {
                type: 'API_FETCH',
                method: 'post',
                path: 'v1/option/get',
                data: {
                    option_name: data.option_name
                }
            };
            if (response.success) {
                yield actions.dashboardsOptionSetValue(response.data);
                yield actions.dashboardsOptionSetStatus({
                    option_name: data.option_name,
                    status: 'ready'
                });
            }
        } catch (e) {
            console.error('Error en hidratación:', e);
        }
    },
    dashboardsOptionSetStatus(data) {
        return {
            type: 'DASHBOARD_OPTION_SET_STATUS',
            payload: data
        };
    },
    dashboardsOptionSetValue(data) {
        return {
            type: 'DASHBOARD_OPTION_SET_VALUE',
            payload: data
        };
    },
    *dashboardsOptionSave(data) {
        try {
            yield actions.dashboardsOptionSetStatus({
                option_name: data.option_name,
                status: 'updating'
            });
            const response = yield {
                type: 'API_FETCH',
                method: 'post',
                path: 'v1/option/update',
                data: {
                    option_name: data.option_name,
                    option_value: data.option_value
                }
            };
            if (response.success) {
                yield actions.dashboardsOptionSetStatus({
                    option_name: data.option_name,
                    status: 'ready'
                });
            }
        } catch (e) {
            console.error('Error en hidratación:', e);
        }
    }
};
