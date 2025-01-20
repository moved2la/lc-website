( function( blocks, element, blockEditor, components ) {
    var el = element.createElement;
    var MediaUpload = blockEditor.MediaUpload;
    var Button = components.Button;
    var BlockControls = blockEditor.BlockControls;
    var Toolbar = components.Toolbar;
    var InspectorControls = blockEditor.InspectorControls;
    var TextControl = components.TextControl;
    var TextareaControl = components.TextareaControl;
    var PanelBody = components.PanelBody;

    blocks.registerBlockType( 'theme-blocks/post-article-image', {
        title: 'Post Article Image',
        icon: 'format-image',
        category: 'livecomplete',
        attributes: {
            imageUrl: {
                type: 'string',
                default: ''
            },
            imageId: {
                type: 'number'
            },
            imageAlt: {
                type: 'string',
                default: ''
            },
            caption: {
                type: 'string',
                default: ''
            }
        },
        edit: function( props ) {
            var attributes = props.attributes;

            function onSelectImage(media) {
                props.setAttributes({
                    imageUrl: media.url,
                    imageId: media.id,
                    imageAlt: media.alt || ''
                });
            }

            return el('div', null, [
                // Inspector Controls for alt text and caption
                el(InspectorControls, { key: 'inspector' },
                    el(PanelBody, {
                        title: 'Image Settings',
                        initialOpen: true
                    },
                        el(TextControl, {
                            label: 'Alt Text',
                            value: attributes.imageAlt,
                            onChange: function(newAlt) {
                                props.setAttributes({ imageAlt: newAlt });
                            },
                            help: 'Describe the purpose of the image. Leave empty if the image is purely decorative.'
                        }),
                        el(TextareaControl, {
                            label: 'Image Caption',
                            value: attributes.caption,
                            onChange: function(newCaption) {
                                props.setAttributes({ caption: newCaption });
                            },
                            help: 'Add a caption to describe or credit the image.'
                        })
                    )
                ),
                // Block Controls for image editing
                el(BlockControls, { key: 'controls' },
                    el(Toolbar, null,
                        el(MediaUpload, {
                            onSelect: onSelectImage,
                            allowedTypes: ['image'],
                            value: attributes.imageId,
                            render: function(obj) {
                                return el(Button, {
                                    icon: 'edit',
                                    onClick: obj.open,
                                    className: 'components-toolbar__control',
                                    label: 'Replace Image'
                                });
                            }
                        })
                    )
                ),
                // Main block content
                el('div', { className: 'post-article-image' },
                    el('div', { className: 'image-container' },
                        attributes.imageUrl ? 
                            el('img', {
                                src: attributes.imageUrl,
                                alt: attributes.imageAlt,
                                onClick: function() {
                                    const mediaUpload = new MediaUpload({
                                        onSelect: onSelectImage,
                                        allowedTypes: ['image'],
                                        value: attributes.imageId,
                                    });
                                    mediaUpload.open();
                                },
                                style: { cursor: 'pointer' }
                            }) :
                            el(MediaUpload, {
                                onSelect: onSelectImage,
                                allowedTypes: ['image'],
                                value: attributes.imageId,
                                render: function(obj) {
                                    return el(Button, {
                                        className: 'button button-large',
                                        onClick: obj.open
                                    }, 'Upload Image');
                                }
                            })
                    ),
                    attributes.imageUrl && attributes.caption && 
                        el('div', { className: 'caption-figure' },
                            el('div', { className: 'image-caption-rectangle' }),
                            el('p', { className: 'image-caption' }, attributes.caption)
                        )
                )
            ]);
        },
        save: function() {
            return null;
        }
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components ); 