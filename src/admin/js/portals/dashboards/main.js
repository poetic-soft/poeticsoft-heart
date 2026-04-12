const { dispatch } = wp.data;
const { DashboardsOptionsManager, DashboardsSectionsOptions } =
    POETICSOFT_HEART.comps;

dispatch(POETICSOFT_HEART.store_key).portalsAdd([
    {
        selector: '.postbox .DashboardWidget.poeticsoft_heart_gemini',
        target: '.Portal',
        comp: <DashboardsOptionsManager />
    },
    {
        selector: '.postbox .DashboardWidget.poeticsoft_heart_deepseek',
        target: '.Portal',
        comp: <DashboardsOptionsManager />
    },
    {
        selector: '.postbox .DashboardWidget.poeticsoft_heart_vlm',
        target: '.Portal',
        comp: <DashboardsOptionsManager />
    },
    {
        selector: '.postbox .DashboardWidget.poeticsoft_heart_sections_options',
        target: '.Portal',
        comp: <DashboardsSectionsOptions />
    }
]);
