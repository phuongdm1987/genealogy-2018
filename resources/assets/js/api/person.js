import axios from 'axios'
import config from '../config'

export default {
    detail (personId) {
        return axios.get(config.api_url + 'persons/' + personId + '?include=contact,biographical');
    },
    update (personId, data) {
        return axios.put(config.api_url + 'persons/' + personId, data);
    },
};
