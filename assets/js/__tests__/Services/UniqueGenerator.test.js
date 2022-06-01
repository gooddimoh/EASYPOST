import { assert, property, integer } from 'fast-check';
import { uniqueGenerator } from 'Services';

test('uniqueGenerator', () => {
    assert(
        property(
            integer({ min: 0, max: 99 }),
            (num) => {
                return uniqueGenerator(num).length === num;
            }
        )
    );
});
