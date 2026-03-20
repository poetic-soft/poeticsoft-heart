const { dispatch } = wp.data;
import config from 'common/js/config';
import AIAgent from './aiagent/main';

dispatch(config.store_key).addPortal({
    selector: '.postbox .DashboardWidget.poeticsoft_heart_gemini',
    target: '.Portal',
    comp: <AIAgent />
});
