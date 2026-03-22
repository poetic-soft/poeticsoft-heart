// src/common/js/store/reducer/dashboard.js
export default (draft, action) => {
    switch (action.type) {
        case 'DASHBOARD_OPTION_SET_STATUS':
            draft.dashboardsOptions[action.payload.optionName].status =
                action.payload.status;
            break;
        case 'DASHBOARD_OPTION_SET_VALUE':
            draft.dashboardsOptions[action.payload.optionName].value =
                action.payload.value;
            break;
    }
};
