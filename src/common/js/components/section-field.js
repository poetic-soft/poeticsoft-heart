/**
 * Componente de campo dinámico (field.js)
 */
const { memo } = wp.element;
const {
    TextControl,
    TextareaControl,
    CheckboxControl,
    ToggleControl,
    SelectControl,
    RadioControl
} = wp.components;

export const SectionField = memo(({ item, onChange, errorMsg }) => {
    const { type, title, description, value, key, options } = item;

    // Props comunes
    const commonProps = {
        label: title,
        help: errorMsg || description,
        value: value,
        onChange: (val) => onChange(key, val),
        className: errorMsg ? 'is-error' : ''
    };

    /**
     * Renderizado según el tipo definido en el esquema
     */
    switch (type) {
        case 'textarea':
            return <TextareaControl {...commonProps} rows={8} />;

        case 'checkbox':
            return (
                <CheckboxControl
                    {...commonProps}
                    checked={!!value}
                    onChange={(val) => onChange(key, val)}
                />
            );

        case 'toggle':
            return (
                <ToggleControl
                    {...commonProps}
                    checked={!!value}
                    onChange={(val) => onChange(key, val)}
                />
            );

        case 'select':
            return <SelectControl {...commonProps} options={options || []} />;

        case 'radio':
            return (
                <RadioControl
                    {...commonProps}
                    options={options || []}
                    onChange={(val) => onChange(key, val)}
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
