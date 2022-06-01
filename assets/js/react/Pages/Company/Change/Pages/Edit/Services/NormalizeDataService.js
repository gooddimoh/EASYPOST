export const responseNormalizer = (data) => {
    return {
        ...data,
        type: data.type.toString(),
    };
};