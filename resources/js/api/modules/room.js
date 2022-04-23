import * as RequestApi from '../request';

export function getAllRoom(url) {
    return RequestApi.getAll(url);
}

export function getOneRoom(url) {
    return RequestApi.getOne(url);
}

export function createRoom(url, data) {
    return RequestApi.postOne(url, data);
}

export function updateRoom(url, data) {
    return RequestApi.putOne(url, data);
}

export function deleteRoom(url, Room_id) {
    return RequestApi.deleteOne(url, Room_id);
}
