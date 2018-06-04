import axios from 'axios'
import config from '../config'

export default () => {
    return axios.get(config.api_url + 'persons/sexes');
};

