// resources/js/app.js

import './bootstrap';
import axios from 'axios';

// Cấu hình Axios
axios.defaults.baseURL = '/api';
axios.interceptors.request.use(config => {
    const token = localStorage.getItem('personal_access_token');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// Hàm đăng nhập
function login(email, password) {
    axios.post('/login', {
        email: email,
        password: password
    })
    .then(response => {
        // Lưu token vào localStorage
        localStorage.setItem('personal_access_token', response.data.token);
        // Điều hướng hoặc thực hiện hành động khác sau khi đăng nhập thành công
        console.log('Đăng nhập thành công!');
    })
    .catch(error => {
        console.error('Đăng nhập thất bại:', error.response.data);
    });
}
// Hàm đăng xuất
function logout() {
    axios.post('/logout')
        .then(response => {
            // Xóa token từ localStorage
            localStorage.removeItem('personal_access_token');
            console.log('Đăng xuất thành công!');
            // Điều hướng đến trang đăng nhập hoặc thực hiện hành động khác
        })
        .catch(error => {
            console.error('Đăng xuất thất bại:', error.response.data);
        });
}

// Ví dụ sử dụng hàm login
// login('user@example.com', 'your_password'); // Gọi hàm này khi cần