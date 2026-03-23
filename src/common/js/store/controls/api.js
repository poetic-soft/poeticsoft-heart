export default {
    API_FETCH(action) {
        const { apiClient } = POETICSOFT_HEART.api;
        return apiClient[action.method](action.path, action.data);
    }
};
