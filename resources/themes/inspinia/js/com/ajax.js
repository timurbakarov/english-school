import Axios from 'axios';

Axios.defaults.headers.common['X-CSRF-TOKEN'] = APP.csrf.token;

export default {
    get(url, config) {
        return Axios.get(url, config)
    },
    post(url, data, config) {
        return Axios.post(url, data, config)
    }
};
