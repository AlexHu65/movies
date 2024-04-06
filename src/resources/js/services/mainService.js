import { client } from "./clientService";

export const getToken = () => localStorage.getItem('token');

export const removeToken = () => localStorage.removeItem('token');

export const setToken = (token) => localStorage.setItem('token' , token);

export const post = (uri, data) => {
    return client.post(uri, data);
}

export const get = (uri) => {
    return client.get(uri);
}

export const deleteData = (uri)  => {
    return client.delete(uri);
}

export const putData = (uri, data) => {
      return client.put(uri, data);
}