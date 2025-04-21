import axios from "axios";

/**
 *  Axios Instance with configuration CORS
 */
const axiosInstance = axios.create({
    baseURL: 'https://localhost:8000/AI-Project/api/', 
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

/**
 * Manage JWT Token 
 */
axiosInstance.interceptors.request.use(config => {
 
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default axiosInstance;