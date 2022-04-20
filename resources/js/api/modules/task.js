import * as RequestApi from '../request';

export function getAllTask(url) {
    return RequestApi.getAll(url);
}

export function getOneTask(url) {
    return RequestApi.getOne(url);
}

export function createTask(url, data) {
    return RequestApi.postOne(url, data);
}

export function updateTask(url, data) {
    return RequestApi.putOne(url, data);
}

export function deleteTask(url, task_id) {
    return RequestApi.deleteOne(url, task_id);
}
