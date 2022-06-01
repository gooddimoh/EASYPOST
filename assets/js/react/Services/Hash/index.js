import hash from 'object-hash';

const sha1 = (data) =>
    hash(data, {
        replacer: (v) => (v instanceof Blob ? v.size : v),
    });

const md5 = hash.MD5;

export { md5, sha1 };
