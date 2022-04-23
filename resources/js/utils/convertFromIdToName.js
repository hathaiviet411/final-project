export function convertFromIDToName(id, array) {
    if (id && array) {
        for (let i = 0; i < array.length; i++) {
            if (array[i].value === id) {
                return array[i].text;
            }
        }
    }

    return '';
}
