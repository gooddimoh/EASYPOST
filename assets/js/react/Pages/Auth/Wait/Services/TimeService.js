export const getMinuteDifference = time => Math.floor((Date.now() - Date.parse(time)) / (1000 * 60));
