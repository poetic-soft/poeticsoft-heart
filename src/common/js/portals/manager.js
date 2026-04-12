const { useState, useEffect } = wp.element;
const { useSelect } = wp.data;
const { createPortal, cloneElement } = wp.element;

export default () => {
    const [portalsList, setPortalList] = useState([]);

    const portalsFromStore = useSelect(
        (select) => select(POETICSOFT_HEART.store_key).portalsGet(),
        []
    );

    useEffect(() => {
        const detected = [];

        portalsFromStore.forEach((portal) => {
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

            setPortalList(detected);
        });
    }, [portalsFromStore]);

    return (
        <>
            {portalsList.length &&
                portalsList.map((p) =>
                    createPortal(p.component, p.target, p.id)
                )}
        </>
    );
};
