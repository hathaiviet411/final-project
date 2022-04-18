export function randomNumber() {
    const min = 0;
    const max = 99;

    return Math.floor(Math.random() * (max - min)) + min;
}
