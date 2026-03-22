export default {
    dashboardsOptionsAdd(options) {
        return { type: 'DASHBOARD_OPTIONS_ADD', payload: options };
    },
    dashboardsOptionsSetValues(values) {
        return { type: 'DASHBOARD_OPTIONS_SET_VALUES', payload: values };
    },
    dashboardsOptionsUpdateValue(optionName, value) {
        return {
            type: 'DASHBOARD_OPTIONS_UPDATE_VALUE',
            payload: { optionName, value }
        };
    },
    dashboardsOptionsSetSaving(isSaving) {
        return { type: 'DASHBOARD_SET_SAVING', payload: isSaving };
    }
};
