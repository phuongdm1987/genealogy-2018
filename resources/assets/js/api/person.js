import axios from 'axios'
import config from '../config'

const detail = (personId) => {
    return axios.get(config.api_url + 'persons/' + personId + '?include=contact,biographical');
};

const update = (personId, data) => {
    return axios.put(config.api_url + 'persons/' + personId, data);
};

export {detail, update};
