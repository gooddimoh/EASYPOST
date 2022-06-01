import React, { Component } from "react";
import * as R from 'ramda';
import PropTypes from "prop-types";
import DragAndDrop from "Widgets/DragAndDrop/DragAndDrop";
import { Img } from 'Templates/Img';

const defaultProps = {
    fileLength: 0,
};

const propTypes = {
    fileLength: PropTypes.number,
    handleDrop: PropTypes.func.isRequired,
    dropFile: PropTypes.func.isRequired,
    files: PropTypes.arrayOf(PropTypes.object).isRequired,
    name: PropTypes.string.isRequired,
};

class FileList extends Component {
    src = [];

    handleDrop = (files) => {
        const { handleDrop, fileLength } = this.props;
        handleDrop([...files].slice(-fileLength));
    };

    dropFile = (key) => {
        const { files, dropFile } = this.props;
        const value = files.filter((item, n) => +n !== +key);

        dropFile(value);
    };

    renderFiles = (files) => {
        if (!files || !R.head(files)) {
            return undefined;
        }

        return (
            <ul className="main-modal__form-list">
                {files.map((item, key) => (
                    <li className="main-modal__form-list-item" key={key}>
                        {item.name}
                        <button type="button" onClick={() => {
                            this.dropFile(key);
                        }}>
                            <Img
                                img="close"
                                alt="Close"
                            />
                        </button>

                    </li>
                ))}
            </ul>
        );
    };

    render() {
        const { name, files } = this.props;

        return (
            <div className="file-list">
                <DragAndDrop name={name} handleDrop={this.handleDrop}>
                    {this.renderFiles(files)}
                </DragAndDrop>
            </div>
        );
    }
}

FileList.defaultProps = defaultProps;
FileList.propTypes = propTypes;

export default FileList;
