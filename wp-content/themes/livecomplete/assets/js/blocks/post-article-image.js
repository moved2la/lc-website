( function( blocks, element, blockEditor ) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;
    var MediaUpload = blockEditor.MediaUpload;
    var Button = wp.components.Button;

    blocks.registerBlockType( 'theme-blocks/post-article-image', {
        title: 'Post Article Image',
        icon: 'format-image',
        category: 'formatting',
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
                    imageAlt: media.alt
                });
            }

            return el('div', { className: 'post-article-image' },
                el('div', { className: 'image-container' },
                    attributes.imageUrl ? 
                        el('img', {
                            src: attributes.imageUrl,
                            alt: attributes.imageAlt
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
                el(RichText, {
                    tagName: 'p',
                    className: 'image-caption',
                    value: attributes.caption,
                    onChange: function(newCaption) {
                        props.setAttributes({ caption: newCaption });
                    },
                    placeholder: 'Add image caption...'
                })
            );
        },
        save: function() {
            return null;
        }
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor ); 