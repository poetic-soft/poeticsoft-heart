const { render } = wp.element;
import Manager from './manager';

const setup = () => {
    const container = document.createElement('div');
    container.id = 'poeticsoft-heart-portal-root';
    container.style.display = 'none';
    document.body.appendChild(container);

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
