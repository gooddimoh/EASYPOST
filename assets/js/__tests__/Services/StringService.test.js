import {stringOf, object, property, assert, base64} from 'fast-check';
import {toCamelCase} from 'Services/Convert';

test('toCamelCase', () => {
    assert(
        property(
            object({
                key: stringOf(base64(), { maxLength: 10 }),
            }),
            (a) => {
                const obj = Object.keys(toCamelCase(a)).join('');

                const match = (_a) => {
                    if (!_a) {
                        return true;
                    }
                    return !_a.match(/([-_][a-z])/gi);
                };

                const data = match(obj);
                expect(data).toBe(true);
            }
        )
    );
});
