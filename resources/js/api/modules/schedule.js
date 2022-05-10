import * as RequestApi from '../request';

export function getAllSchedule(url) {
    return RequestApi.getAll(url);
}

export function getOneSchedule(url) {
    return RequestApi.getOne(url);
}

export function createSchedule(url, data) {
    return RequestApi.postOne(url, data);
}

export function updateSchedule(url, data) {
    return RequestApi.putOne(url, data);
}

// export function deleteSchedule(url, Schedule_id) {
//     return RequestApi.deleteOne(url, Schedule_id);
// }
