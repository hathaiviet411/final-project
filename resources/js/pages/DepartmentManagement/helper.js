export function getYMDFromString(string) {
    if (string) {
        const result = string.slice(0, 10);
        return result;
    }

    return 'Error';
}
