const { dispatch } = wp.data;
const { DashboardsOptionsManager } = POETICSOFT_HEART.comps;

dispatch(POETICSOFT_HEART.store_key).portalsAdd({
    selector: '.postbox .DashboardWidget.poeticsoft_heart_gemini',
    target: '.Portal',
    comp: <DashboardsOptionsManager />
});

dispatch(POETICSOFT_HEART.store_key).portalsAdd({
    selector: '.postbox .DashboardWidget.poeticsoft_heart_deepseek',
    target: '.Portal',
    comp: <DashboardsOptionsManager />
});

dispatch(POETICSOFT_HEART.store_key).portalsAdd({
    selector: '.postbox .DashboardWidget.poeticsoft_heart_vlm',
    target: '.Portal',
    comp: <DashboardsOptionsManager />
});
