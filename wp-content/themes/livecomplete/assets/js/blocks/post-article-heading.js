( function( blocks, element, blockEditor ) {
    var el = element.createElement;
    var RichText = blockEditor.RichText;

    blocks.registerBlockType( 'theme-blocks/post-article-heading', {
        title: 'Post Article Heading',
        icon: 'heading',
        category: 'livecomplete',
        attributes: {
            introText: {
                type: 'string',
                default: 'Introduction'
            }
        },
        edit: function( props ) {
            return el(
                'div',
                { className: 'post-article-heading' },
                el(RichText, {
                    tagName: 'div',
                    className: 'introduction',
                    value: props.attributes.introText,
                    onChange: function(newText) {
                        props.setAttributes({ introText: newText });
                    },
                    placeholder: 'Enter introduction text...'
                })
            );
        },
        save: function() {
            return null; // Dynamic block, render callback handles the frontend
        }
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor ); 