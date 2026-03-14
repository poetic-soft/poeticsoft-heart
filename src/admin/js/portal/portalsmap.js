import DashboardEditor from './dashboard-editor/dashboard-editor';

export const portalsMap = {
    '.postbox .DashboardWidget.gemini': {
        target: '.Portal',
        comp: <DashboardEditor />
    }
};
