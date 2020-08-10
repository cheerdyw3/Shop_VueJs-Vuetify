import axios from 'axios';
export const HTTP = axios.create({
    // baseURL: process.env.VUE_APP_API+'api/v1', 
    baseURL: 'http://localhost/adminAppLK/public/api/v1',
    headers: {
        "Content-Type": "text/json",
    }
});
