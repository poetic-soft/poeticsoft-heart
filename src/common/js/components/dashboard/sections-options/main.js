const { memo } = wp.element;
const { Tooltip } = wp.components;

const Option = (props) => {
    return (
        <div className="option">
            <div className="title">{props.option_title}</div>
            <div className="name">{props.option_name}</div>
        </div>
    );
};

const Section = (props) => {
    return (
        <div className="section">
            <div className="title">{props.title}</div>
            <div className="options">
                {props.options.map((option) => (
                    <Option {...option} />
                ))}
            </div>
        </div>
    );
};

export const DashboardsSectionsOptions = memo((props) => {
    return (
        <div className="dashboard-sections-options">
            {props.data.map((section) => (
                <Section {...section} />
            ))}
        </div>
    );
});
