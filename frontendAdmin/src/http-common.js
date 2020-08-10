import axios from 'axios';

export const HTTP = axios.create({
  baseURL: 'http://missmed.co.th/s1/api/v1',
  headers: {
    Authorization: 'Bearer {token}'
  }
})