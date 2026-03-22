// src/common/js/components/dashboard/options/manager.js
const { memo } = wp.element;
import { DashboardOptionsField } from './field';

export const DashboardOptionsManager = memo((props) => {
    return (
        <div className="dashboard-options">
            {props.data.map((option) => (
                <DashboardOptionsField {...option} />
            ))}
        </div>
    );
});
