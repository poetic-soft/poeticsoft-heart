const { useState } = wp.element;
const { useSelect } = wp.data;
const { createPortal, cloneElement } = wp.element;

import config from 'common/js/config';

export default () => {
    const [portalList, setPortalList] = useState([]);
    useSelect((select) => {
        const detected = [];
        const portals = select(config.store_key).portalsGet();

        portals.forEach((portal) => {
            const selector = portal.selector;
            const elements = document.querySelectorAll(selector);
            elements.forEach((el) => {
                const target = el.querySelector(portal.target);
                if (target) {
                    if (!target.dataset.portalInitialized) {
                        target.innerHTML = '';
                        target.dataset.portalInitialized = 'true';
                    }
                    const id = target.id;
                    const targetData = el.querySelector('script.data');
                    let data = null;
                    try {
                        data = targetData
                            ? JSON.parse(targetData.textContent)
                            : null;
                    } catch (e) {
                        console.warn(`JSON corrupto en ${id}`);
                    }

                    detected.push({
                        id,
                        target,
                        component: cloneElement(portal.comp, {
                            data,
                            rootElement: el,
                            boxId: id
                        })
                    });
                }
            });
        });

        setPortalList((prevPortals) => {
            if (prevPortals.length !== detected.length) return detected;
            const hasChanges = detected.some(
                (p, i) =>
                    p.id !== prevPortals[i].id ||
                    p.target !== prevPortals[i].target
            );
            return hasChanges ? detected : prevPortals;
        });
    }, []);

    return (
        <>{portalList.map((p) => createPortal(p.component, p.target, p.id))}</>
    );
};
