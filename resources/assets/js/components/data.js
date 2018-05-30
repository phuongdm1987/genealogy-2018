import axios from 'axios'

export const data = () => {
    return axios.get('http://genealogy.test:81/maps');
}
