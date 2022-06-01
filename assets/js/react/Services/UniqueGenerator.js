import { nanoid } from 'nanoid';

export const uniqueGenerator = (len = 8) => nanoid(len);
