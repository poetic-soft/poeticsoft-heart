export default {
    dashboardsOptionSetStatus(data) {
        return {
            type: 'DASHBOARD_OPTION_SET_STATUS',
            payload: data
        };
    },
    dashboardsOptionSetValue(data) {
        console.log(data);
        return {
            type: 'DASHBOARD_OPTION_SET_VALUE',
            payload: data
        };
    }
};
