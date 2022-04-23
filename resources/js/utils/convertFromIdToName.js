export function toPositionName(position_id, array) {
    if (position_id >= 0 && array) {
        for (let i = 0; i < array.length; i++) {
            if (array[i].value === position_id) {
                return array[i].text;
            }
        }
    }

    return '';
}

export function toContractType(contract_id, array) {
    if (contract_id >= 0 && array) {
        for (let i = 0; i < array.length; i++) {
            if (array[i].value === contract_id) {
                return array[i].text;
            }
        }
    }

    return '';
}
