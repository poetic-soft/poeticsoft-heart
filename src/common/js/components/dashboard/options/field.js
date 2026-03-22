const { memo } = wp.element;
const { useSelect, useDispatch } = wp.data;
const {
    TextControl,
    TextareaControl,
    CheckboxControl,
    ToggleControl,
    SelectControl,
    RadioControl
} = wp.components;

export const DashboardOptionsField = memo((option) => {
    const store_key = POETICSOFT_HEART.store_key;

    const { type, title, description, value, option_name } = option;

    const onChange = (optionName, value) => {
        console.log(optionName, value);
    };

    const errorMsg = null;

    const optionValue = useSelect((select) => {
        return select(store_key).dashboardsOptionGet(option_name);
    });

    const commonProps = {
        label: title,
        help: errorMsg || description,
        value: value || optionValue,
        onChange: (val) => onChange(optionName, val),
        className: errorMsg ? 'is-error' : ''
    };

    switch (type) {
        case 'textarea':
            return <TextareaControl {...commonProps} rows={8} />;

        case 'checkbox':
            return (
                <CheckboxControl
                    {...commonProps}
                    checked={!!value}
                    onChange={(val) => onChange(optionName, val)}
                />
            );

        case 'toggle':
            return (
                <ToggleControl
                    {...commonProps}
                    checked={!!value}
                    onChange={(val) => onChange(optionName, val)}
                />
            );

        case 'select':
            return <SelectControl {...commonProps} options={options || []} />;

        case 'radio':
            return (
                <RadioControl
                    {...commonProps}
                    options={options || []}
                    onChange={(val) => onChange(optionName, val)}
                />
            );

        case 'email':
        case 'number':
        case 'tel':
        case 'url':
            return <TextControl {...commonProps} type={type} />;

        case 'text':
        default:
            return <TextControl {...commonProps} />;
    }
});
