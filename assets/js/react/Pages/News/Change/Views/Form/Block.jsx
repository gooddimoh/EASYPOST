import React from 'react';
import { compose } from 'ramda';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import connect from 'Hoc/Template/Connect';
import { FormBody, FormRow, FormCol, WrapInput, EasyCrop, FormTitle } from 'Templates/Form';
import { Input } from 'Templates/Input';

const propTypes = {
    title: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    description: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    link: PropTypes.shape({
        value: PropTypes.string.isRequired,
        errors: PropTypes.arrayOf(PropTypes.string),
    }).isRequired,
    photo: PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    onChange: PropTypes.func.isRequired,
};

const Block = ({ title, description, link, photo, onChange }) => {

    return (
        <FormBody>

            <FormRow>
                <FormTitle title="General Info" />
            </FormRow>

            <FormRow>
                <FormCol>
                    <WrapInput name="title" label="News title" errors={title.errors} required>
                        <Input value={title.value} onChange={onChange('title')} />
                    </WrapInput>
                </FormCol>

                <FormCol>
                    <WrapInput name="link" label="News link" errors={link.errors} required>
                        <Input value={link.value} onChange={onChange('link')} />
                    </WrapInput>
                </FormCol>
            </FormRow>

            <FormRow>
                <FormCol>
                    <WrapInput name="description" label="Description" errors={description.errors} required>
                        <Input type="textarea" value={description.value} onChange={onChange('description')} />
                    </WrapInput>
                </FormCol>

                <FormCol>
                    <WrapInput name="photo" errors={photo.errors} required>
                        <EasyCrop value={photo.value} onChange={onChange('photo')} />
                    </WrapInput>
                </FormCol>
            </FormRow>

        </FormBody>
    );
};

Block.propTypes = propTypes;

const mapStateToProps = (state, { service: { getStoreItem } }) => {
    return {
        title: {
            value: getStoreItem(state, 'title', ''),
            errors: getStoreItem(state, ['formErrors', 'title'], []),
        },
        description: {
            value: getStoreItem(state, 'description', ''),
            errors: getStoreItem(state, ['formErrors', 'description'], []),
        },
        link: {
            value: getStoreItem(state, 'link', ''),
            errors: getStoreItem(state, ['formErrors', 'link'], []),
        },
        photo: {
            value: getStoreItem(state, 'photo', ''),
            errors: getStoreItem(state, ['formErrors', 'photo'], []),
        },
    };
};

const mapDispatchToProps = ({ service: { getActionStore } }) => {
    return {
        onChange: getActionStore('onChange'),
    };
};

export default compose(withTagDefaultProps, connect(mapStateToProps, mapDispatchToProps))(Block);
