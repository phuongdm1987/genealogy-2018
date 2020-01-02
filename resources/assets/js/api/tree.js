import axios from 'axios'
import config from '../config'

export default {
    getTree () {
        return axios.get(config.api_url + 'maps');
    }
};
