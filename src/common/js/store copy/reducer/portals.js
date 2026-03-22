export default (draft, action) => {
    switch (action.type) {
        case 'PORTALS_ADD':
            draft.portals.push(action.payload);
            break;
    }
};
