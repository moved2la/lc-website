( function( blocks, element, blockEditor ) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;

    blocks.registerBlockType( 'theme-blocks/post-article-paragraph', {
        title: 'Post Article Paragraph',
        icon: 'text',
        category: 'livecomplete',
        attributes: {
            content: {
                type: 'string',
                default: ''
            }
        },
        edit: function( props ) {
            return el(
                'div',
                { className: 'post-article-paragraph' },
                el(RichText, {
                    tagName: 'p',
                    className: 'paragraph-content',
                    value: props.attributes.content,
                    onChange: function(newContent) {
                        props.setAttributes({ content: newContent });
                    },
                    placeholder: 'Enter paragraph text...'
                })
            );
        },
        save: function() {
            return null; // Dynamic block, render callback handles the frontend
        }
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor ); 