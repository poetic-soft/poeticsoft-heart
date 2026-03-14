const { render } = wp.element;
import PortalManager from './js/portal/manager';
import './main.scss';

const setup = () => {
    const container = document.createElement('div');
    container.id = 'poeticsoft-heart-portal-root';
    container.style.display = 'none';
    document.body.appendChild(container);

    render(<PortalManager />, container);
};

if (
    document.readyState === 'complete' ||
    document.readyState === 'interactive'
) {
    setup();
} else {
    document.addEventListener('DOMContentLoaded', setup);
}
