const { dispatch } = wp.data;
const { DashboardOptionsManager } = POETICSOFT_HEART.comps;

dispatch(POETICSOFT_HEART.store_key).portalsAdd({
    selector: '.postbox .DashboardWidget.poeticsoft_heart_gemini',
    target: '.Portal',
    comp: <DashboardOptionsManager />
});
