const { render } = wp.element;
import Manager from './manager';

const setup = () => {
    const container = document.getElementById('poeticsoft-heart-portal-root');

    render(<Manager />, container);
};

if (
    document.readyState === 'complete' ||
    document.readyState === 'interactive'
) {
    setup();
} else {
    document.addEventListener('DOMContentLoaded', setup);
}
