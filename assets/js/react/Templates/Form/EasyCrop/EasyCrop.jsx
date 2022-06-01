import React, { useState, useCallback, useRef, useEffect } from 'react';
import Cropper from 'react-easy-crop';
import PropTypes from 'prop-types';
import { withTagDefaultProps } from 'Hoc/Template';
import attachFile from 'Services/FileService';
import { BorderButton } from 'Templates/Button';
import { Img, ImgStorage } from 'Templates/Img';
import { close, showModal } from 'Widgets/Modal';
import { getCroppedImg, readFile } from './utils';

const propTypes = {
    value: PropTypes.oneOfType([PropTypes.string, PropTypes.object]).isRequired,
    t: PropTypes.func.isRequired,
    onChange: PropTypes.func.isRequired,
};

const EasyModal = ({ t, fileImage, setImage, onChange, setIsOpen, kModal }) => {
    const aspect = 1;
    const rotation = 0;

    const [croppedAreaPixels, setCroppedAreaPixels] = useState(null);
    const [crop, setCrop] = useState({ x: 0, y: 0 });
    const [zoom, setZoom] = useState(1);

    const onCropComplete = useCallback((croppedArea, _croppedAreaPixels) => {
        setCroppedAreaPixels(_croppedAreaPixels);
    }, []);

    const showCroppedImage = useCallback(async () => {
        try {
            const _croppedImage = await getCroppedImg(fileImage, croppedAreaPixels);
            attachFile(_croppedImage).then((src) => {
                onChange(_croppedImage);
                setImage(src);
                setIsOpen(false);
                close(kModal);
            });
        } catch (e) {
            // eslint-disable-next-line no-console
            console.error(e);
        }
    }, [fileImage, croppedAreaPixels]);

    return (
        <>
            <div className="easy-crop">
                <Cropper
                    image={fileImage}
                    crop={crop}
                    rotation={rotation}
                    zoom={zoom}
                    aspect={aspect}
                    cropSize={{ width: 320, height: 320 }}
                    onCropChange={setCrop}
                    onCropComplete={onCropComplete}
                    onZoomChange={setZoom}
                />
            </div>
            <div className="modal__text">{t('Use mouse scroll to resize image')}</div>
            <BorderButton name="save" onClick={showCroppedImage}>
                {t('Save photo')}
            </BorderButton>
        </>
    );
};

const EasyCrop = ({ value, t, onChange }) => {
    const [fileImage, setFileImage] = useState(null);
    const [image, setImage] = useState(null);
    const [isOpen, setIsOpen] = useState(false);
    const ref = useRef();

    const onFileChange = async (e) => {
        if (e.target.files && e.target.files.length > 0) {
            const file = e.target.files[0];
            const imageDataUrl = await readFile(file);
            setFileImage(imageDataUrl);
            setIsOpen(true);
            ref.current.value = '';
        }
    };

    const handleClickOnUpload = () => ref.current.click();

    const renderPreview = (img) => {
        if (!img) return <Img img="form-logo-square-min" alt="default-avatar" />;
        if (typeof img === 'string') return <ImgStorage url={img} alt="avatar" />;
        return <img src={image} alt="avatar" />;
    };

    const onClickDelete = () => {
        onChange('');
        ref.current.value = '';
    };

    useEffect(() => {
        if (isOpen) {
            showModal(
                <EasyModal onChange={onChange} fileImage={fileImage} setImage={setImage} setIsOpen={setIsOpen} t={t} />,
                () => setIsOpen(false),
            );
        }
    }, [isOpen]);

    return (
        <div>
            <div className="cropper">
                <div className="cropper__preview">
                    {renderPreview(value)}
                    {value && (
                        <button type="button" className="cropper__delete" onClick={onClickDelete}>
                            <Img img="close" alt="delete-button" />
                        </button>
                    )}
                </div>
                <input type="file" ref={ref} onChange={onFileChange} accept="image/*" className="visuallyhidden" />
                <BorderButton name="upload-avatar" onClick={handleClickOnUpload}>
                    {t('Upload')}
                </BorderButton>
            </div>
        </div>
    );
};

EasyCrop.propTypes = propTypes;

export default withTagDefaultProps(EasyCrop);
