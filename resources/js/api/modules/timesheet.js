import * as RequestApi from '../request';

export function getAllTimesheet(url) {
    return RequestApi.getAll(url);
}

export function getOneTimesheet(url) {
    return RequestApi.getOne(url);
}

export function createTimesheet(url, data) {
    return RequestApi.postOne(url, data);
}

export function updateTimesheet(url, data) {
    return RequestApi.putOne(url, data);
}
