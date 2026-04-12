export default (draft, action) => {
    switch (action.type) {
        case 'PORTALS_ADD':
            action.payload.forEach((portal) => {
                draft.portals.push(portal);
            });
            break;
    }
};
