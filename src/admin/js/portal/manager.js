const { useState, useEffect, useCallback, createPortal, cloneElement } =
    wp.element;
import { portalsMap } from './portalsmap';

const ADMIN_ROOT = '#wpbody-content .wrap';

const PortalManager = () => {
    return <>QUE PASA</>;
    const [portals, setPortals] = useState([]);

    const scan = useCallback(() => {
        // console.count('scan'); // Parar el observer?

        const detected = [];

        Object.keys(portalsMap).forEach((selector) => {
            console.log(selector);
            const elements = document.querySelectorAll(selector);

            elements.forEach((el) => {
                const config = portalsMap[selector];

                const target = el.querySelector(config.target);

                if (target) {
                    if (!target.dataset.portalInitialized) {
                        target.innerHTML = '';
                        target.dataset.portalInitialized = 'true';
                    }

                    const id = target.id;
                    const targetData = el.querySelector('script.data');
                    let data = [];
                    try {
                        data = targetData
                            ? JSON.parse(targetData.textContent)
                            : [];
                    } catch (e) {
                        console.warn(`JSON corrupto en ${id}`);
                    }

                    detected.push({
                        id,
                        target,
                        component: cloneElement(config.comp, {
                            data,
                            rootElement: el,
                            boxId: id
                        })
                    });
                }
            });
        });

        setPortals((prevPortals) => {
            if (prevPortals.length !== detected.length) return detected;

            const hasChanges = detected.some(
                (p, i) =>
                    p.id !== prevPortals[i].id ||
                    p.target !== prevPortals[i].target
            );

            return hasChanges ? detected : prevPortals;
        });
    }, []);

    useEffect(() => {
        scan();

        const adminRoot = document.querySelector(ADMIN_ROOT);
        const observer = new MutationObserver(scan);
        observer.observe(adminRoot, {
            childList: true,
            subtree: true
        });
    }, [scan]);

    return (
        <>
            {portals.map((p) => {
                console.log(p.target);
                createPortal(p.component, p.target, p.id);
            })}
        </>
    );
};

export default PortalManager;
