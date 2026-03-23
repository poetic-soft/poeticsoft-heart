// src/common/js/components/dashboard/options/manager.js
const { memo } = wp.element;
import { DashboardsOptionsField } from './field';

export const DashboardsOptionsManager = memo((props) => {
    return (
        <div className="dashboard-options">
            {props.data.map((option) => (
                <DashboardsOptionsField {...option} />
            ))}
        </div>
    );
});
