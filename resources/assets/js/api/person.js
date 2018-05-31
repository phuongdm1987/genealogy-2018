import axios from 'axios'
import config from '../config'

export const personDetail = (personId) => {
    return axios.get(config.api_url + 'persons/' + personId + '?include=contact,biographical');
};
