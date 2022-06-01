import React, {Component} from "react";
import PropTypes from 'prop-types';
import {Img} from "Templates/Img";
import {info} from '../Modal';

const propTypes = {
    handleDrop: PropTypes.func.isRequired,
};

class DragAndDrop extends Component {
    dragCounter = 0;

    // TODO drag
    // state = {
    //     drag: false,
    // };

    dropRef = React.createRef();

    componentDidMount() {
        const div = this.dropRef.current;
        div.addEventListener("dragenter", this.handleDragIn);
        div.addEventListener("dragleave", this.handleDragOut);
        div.addEventListener("dragover", this.handleDrag);
        div.addEventListener("drop", this.handleDrop);
    }

    componentWillUnmount() {
        const div = this.dropRef.current;
        div.removeEventListener("dragenter", this.handleDragIn);
        div.removeEventListener("dragleave", this.handleDragOut);
        div.removeEventListener("dragover", this.handleDrag);
        div.removeEventListener("drop", this.handleDrop);
    }

    formatData = (files) => {
        const maxSize = 25;
        for (let i = 0; i < files.length; i += 1) {
            if (files[i].size >= maxSize * 1024 * 1024) {
                info("Maximum file size 25Mb");
                return;
            }
        }
        const { handleDrop } = this.props;

        handleDrop(files);
    };

    handleDrag = (e) => {
        e.preventDefault();
        e.stopPropagation();
    };

    handleDragIn = (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.dragCounter++;
        if (e.dataTransfer.items && e.dataTransfer.items.length > 0) {
            // TODO drag
            // this.setState({ drag: true });
        }
    };

    handleDragOut = (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.dragCounter--;
        if (this.dragCounter === 0) {
            // TODO drag
            // this.setState({ drag: false });
        }
    };

    handleDrop = (e) => {
        e.preventDefault();
        e.stopPropagation();
        // TODO drag
        // this.setState({ drag: false });
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            this.formatData(e.dataTransfer.files);
            e.dataTransfer.clearData();
            this.dragCounter = 0;
        }
    };

    onChange = (e) => {
        e.preventDefault();
        e.stopPropagation();
        // TODO drag
        // this.setState({ drag: false });
        this.formatData(e.target.files);
    };

    render() {
        const { children } = this.props;
        const list = React.Children.count(children);
        return (
            <div className={`main-modal__form-wrap ${list && "main-modal__form-wrap_flex"}`}>
                <div className="main-modal__form-file" ref={this.dropRef}>
                    <Img img="input_file_img"/>
                    <div className="main-modal__form-file-wrap-text">
                        <h4 className="main-modal__form-file-h4">Drag and Drop to Upload</h4>
                        <div className="main-modal__form-file-text">
                            or{" "}
                            <a href="#" className="main-modal__form-file-link">
                                Browse
                            </a>{" "}
                            to choose a file
                        </div>
                        <div className="main-modal__form-file-text">Maximum file size 25Mb</div>
                    </div>
                    <input
                        className="main-modal__form-file-input"
                        type="file"
                        value=""
                        multiple=""
                        onChange={this.onChange}
                    />
                </div>
                {children}
            </div>
        );
    };
}

DragAndDrop.propTypes = propTypes;

export default DragAndDrop;
