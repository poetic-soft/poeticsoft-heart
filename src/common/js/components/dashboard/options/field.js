const { memo, useEffect } = wp.element;
const { useSelect, useDispatch } = wp.data;
const {
    TextControl,
    TextareaControl,
    CheckboxControl,
    ToggleControl,
    SelectControl,
    RadioControl,
    Tooltip,
    Button
} = wp.components;

const Field = ({ type, commonProps }) => {
    switch (type) {
        case 'textarea':
            return <TextareaControl {...commonProps} rows={8} />;

        case 'checkbox':
            return (
                <CheckboxControl
                    {...commonProps}
                    checked={!!commonProps.value}
                />
            );

        case 'toggle':
            return (
                <ToggleControl {...commonProps} checked={!!commonProps.value} />
            );

        case 'select':
            return <SelectControl {...commonProps} />;

        case 'radio':
            return <RadioControl {...commonProps} />;

        case 'email':
        case 'number':
        case 'tel':
        case 'url':
            return <TextControl {...commonProps} />;

        case 'text':
        default:
            return <TextControl {...commonProps} />;
    }
};

export const DashboardsOptionsField = memo((option) => {
    const store_key = POETICSOFT_HEART.store_key;

    const {
        type,
        title,
        description,
        value,
        option_name: option_name
    } = option;

    const dashboardsOption = useSelect((select) => {
        return select(store_key).dashboardsOptionGet(option_name);
    });

    const {
        dashboardsOptionSet,
        dashboardsOptionLoadValue,
        dashboardsOptionSetValue,
        dashboardsOptionSetStatus,
        dashboardsOptionSave
    } = useDispatch(store_key);

    const onChange = (value) => {
        dashboardsOptionSetStatus({
            option_name: option_name,
            status: 'dirty'
        });
        dashboardsOptionSetValue({
            option_name: option_name,
            option_value: value
        });
    };
    const save = () => {
        dashboardsOptionSave({
            option_name: option_name,
            option_value: dashboardsOption.value
        });
    };

    // if (dashboardsOption && option_name == 'poeticsoft_heart_gemini_key') {
    //     console.log(dashboardsOption);
    // }

    const editAllowed =
        !dashboardsOption ||
        dashboardsOption.status == 'ready' ||
        dashboardsOption.status == 'dirty';
    const saveAllowed = dashboardsOption && dashboardsOption.status == 'dirty';
    const iconStatus = {
        // ready, loading, updating, dirty
        dirty: 'saved',
        ready: 'edit',
        loading: 'update-alt',
        updating: 'update',
        none: 'ellipsis'
    };

    const commonProps = {
        label: title,
        help: description,
        value: dashboardsOption?.value || value,
        onChange: onChange,
        className: dashboardsOption?.status,
        disabled: !editAllowed
    };

    useEffect(() => {
        dashboardsOptionSet(option);
        dashboardsOptionLoadValue({
            option_name: option_name
        });
    }, []);

    console.log(title);

    return (
        <div className="option-field">
            <div className="field">
                {<Field type={type} commonProps={commonProps} />}
            </div>
            <Tooltip text={`Guardar [ ${title} ]`} placement="left">
                <Button
                    variant="primary"
                    icon={iconStatus[dashboardsOption?.status || 'none']}
                    disabled={!saveAllowed}
                    onClick={save}
                />
            </Tooltip>
        </div>
    );
});
