import axios from 'axios'
import config from '../config'

export const treeData = () => {
    return axios.get(config.api_url + 'maps');
};
