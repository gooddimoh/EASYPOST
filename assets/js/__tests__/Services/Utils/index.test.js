import { assert, property, object, dictionary, hexa } from 'fast-check';
import { isPlainObject } from 'Services/Utils';

test('Object is plain', () => {
    assert(
        property(
            dictionary(hexa(), object()),
            (data) => {
                const checkEmpty = (a) => {
                    if (!Object.keys(a).length) return false;
                    return !isPlainObject(a);
                };                
                const result = checkEmpty(data);
                expect(result).toBe(false);
            }
        )
    );
});
