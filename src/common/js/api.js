/**
 * Servicio de API centralizado para Playmotiv
 */
const { apiFetch } = wp;

const API_BASE = 'poeticsoft/heart';
const IS_DEV = true; // Cambiar a false en producción

export const apiClient = {
    /**
     * Helper para logs de desarrollo
     */
    _log(endpoint, response) {
        if (!IS_DEV) return;
        const { data } = response;
        const meta = data?.meta;
        console.groupCollapsed(
            `%c API: ${endpoint}`,
            'color: #007cba; font-weight: bold;'
        );
        if (meta) {
            console.log(`Fecha API: ${meta.fecha}`);
            console.log(`Timestamp: ${meta.timestampms}`);
        }
        // console.log('Respuesta completa:', response);
        console.log('data:', response.data.data);
        console.groupEnd();
    },

    /**
     * Request principal
     */
    async request(endpoint, method = 'GET', body = null) {
        const path = `${API_BASE}/${endpoint.replace(/^\//, '')}`;

        try {
            const response = await apiFetch({
                path: path,
                method: method,
                data: body
            });

            // this._log(endpoint, response);

            // Validamos la estructura anidada de Playmotiv
            if (response && response.data && response.data.success) {
                return {
                    success: true,
                    data: response.data.data,
                    meta: response.data.meta,
                    status: response.data.status
                };
            }

            // Error controlado por la lógica de la API
            return {
                success: false,
                message:
                    response.data?.error || 'La operación no pudo completarse.',
                status: response.data?.status || 400
            };
        } catch (error) {
            // Error de infraestructura (404, 500, rest_no_route, etc)
            console.error(`Error crítico en ${endpoint}:`, error);
            return {
                success: false,
                message:
                    error.message || 'Error de comunicación con el servidor.',
                code: error.code || 'unknown_error'
            };
        }
    },

    get(endpoint, params = null) {
        return this.request(endpoint, 'GET', params);
    },

    post(endpoint, data = null) {
        return this.request(endpoint, 'POST', data);
    }
};
