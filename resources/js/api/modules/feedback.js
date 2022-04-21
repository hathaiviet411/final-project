import * as RequestApi from '../request';

export function getAllFeedback(url) {
    return RequestApi.getAll(url);
}

export function getOneFeedback(url) {
    return RequestApi.getOne(url);
}

export function createFeedback(url, data) {
    return RequestApi.postOne(url, data);
}

export function updateFeedback(url, data) {
    return RequestApi.putOne(url, data);
}

export function deleteFeedback(url, Feedback_id) {
    return RequestApi.deleteOne(url, Feedback_id);
}
