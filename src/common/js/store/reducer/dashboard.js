export default (draft, action) => {
    switch (action.type) {
        case 'DASHBOARD_OPTION_SET':
            draft.dashboardsOptions[action.payload.option_name] =
                action.payload;
            break;
        case 'DASHBOARD_OPTION_LOAD_VALUE':
            draft.dashboardsOptions[action.payload.option_name] =
                action.payload;
            break;
        case 'DASHBOARD_OPTION_SET_STATUS':
            draft.dashboardsOptions[action.payload.option_name].status =
                action.payload.status;
            break;
        case 'DASHBOARD_OPTION_SET_VALUE':
            draft.dashboardsOptions[action.payload.option_name].value =
                action.payload.option_value;
            break;
    }
};
