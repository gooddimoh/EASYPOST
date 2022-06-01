import { isNil } from "ramda";

export class ValidateDTO {
    constructor(status, errors = []) {
        this.status = status;
        this.errors = errors;
    };
}

export const safeValid = (wrapped) => (val) => {
    if (isNil(val)) return new ValidateDTO(true);

    return wrapped(val);
};
