import * as RequestApi from '../request';

export function getAllFacility(url) {
    return RequestApi.getAll(url);
}

export function getOneFacility(url) {
    return RequestApi.getOne(url);
}

export function createFacility(url, data) {
    return RequestApi.postOne(url, data);
}

export function updateFacility(url, data) {
    return RequestApi.putOne(url, data);
}

export function deleteFacility(url, department_id) {
    return RequestApi.deleteOne(url, department_id);
}
