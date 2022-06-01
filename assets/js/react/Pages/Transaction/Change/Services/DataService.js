export const dataRequestNormalizer = (data) => ({
    ...data,
    balance: data.balance*100
});
