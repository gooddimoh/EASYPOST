import { assert, property, object } from 'fast-check';
import { md5, sha1 } from 'Services';

test('String is a MD5 hash', () => {
    assert(
        property(
            object(),
            (data) => {
                const regexExp = /^[a-f0-9]{32}$/gi;
                return regexExp.test(md5(data)) ;
            }
        )
    );
});

test('String is a SHA1 hash', () => {
    assert(
        property(
            object(),
            (data) => {
                const regexExp = /^[a-f0-9]{40}$/gi;
                return regexExp.test(sha1(data)) ;
            }
        )
    );
});
