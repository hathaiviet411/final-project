export function convertFromIDToName(id, array) {
    // Special case
    if (id === null) {
        console.log('Special Case');
        return array[0].text;
    }

    if (id && array) {
        for (let i = 0; i < array.length; i++) {
            if (array[i].value === id) {
                return array[i].text;
            }
        }
    }

    return '';
}
