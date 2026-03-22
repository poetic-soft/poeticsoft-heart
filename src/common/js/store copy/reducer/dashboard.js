// src/common/js/store/reducer/dashboard.js
export default (draft, action) => {
    switch (action.type) {
        case 'DASHBOARD_OPTIONS_ADD':
            action.payload.forEach((option) => {
                if (!draft.dashboardsOptions.options[option.optionName]) {
                    draft.dashboardsOptions.options[option.optionName] = option;
                }
            });
            break;

        case 'DASHBOARD_OPTIONS_SET_VALUES':
            console.log(action.payload);

            Object.entries(action.payload).forEach(([optionName, value]) => {
                if (draft.dashboardsOptions.options[optionName]) {
                    draft.dashboardsOptions.options[optionName].value = value;
                }
            });
            break;

        case 'DASHBOARD_OPTIONS_UPDATE_VALUE': {
            const { optionName, value } = action.payload;
            if (draft.dashboardsOptions.options[optionName]) {
                draft.dashboardsOptions.options[optionName].value = value;
                draft.dashboardsOptions.isDirty = true; // Marcamos que hay cambios sin guardar
            }
            break;
        }

        case 'DASHBOARD_SET_SAVING':
            draft.dashboardsOptions.isSaving = action.payload;
            break;

        case 'DASHBOARD_OPTIONS_SET_FEEDBACK': {
            const { optionName, status, message } = action.payload;
            if (!draft.dashboardsOptions.feedback)
                draft.dashboardsOptions.feedback = {};
            draft.dashboardsOptions.feedback[optionName] = { status, message };
            break;
        }

        case 'DASHBOARD_OPTIONS_CLEAR_FEEDBACK':
            if (draft.dashboardsOptions.feedback) {
                delete draft.dashboardsOptions.feedback[action.payload];
            }
            break;
    }
};
