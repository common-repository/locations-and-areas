import 'core-js';
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { Dashicon } from '@wordpress/components';


registerBlockType( 'locations-and-areas/map', {
    apiVersion: 2,
    title: __( 'Locations and Areas Map', 'locations-and-areas' ),
    description: __('This block will show your Locations and Areas on a map in the front end.', 'locations-and-areas'),
    icon: 'location-alt',
    category: 'widgets',
    example: {},
    attributes: {},
    edit: ({attributes, setAttributes}) => {
        const blockProps = useBlockProps();

        // Render
        return ([
            <div { ...blockProps }>
                <div class="hint">
                    <h5>{ __('Locations and Areas Map', 'locations-and-areas') }</h5>
                    <p>
                        { __('This block will show your', 'locations-and-areas') } <a href="edit.php?post_type=laa-location">{ __('Locations', 'locations-and-areas') }</a> { __('and', 'locations-and-areas') } <a href="edit-tags.php?taxonomy=laa-area&post_type=laa-location">{ __('Areas', 'locations-and-areas') }</a> { __('on a map in the front end.', 'locations-and-areas') } <a class="link-laa-settings" href="options-general.php?page=locations_and_areas"><Dashicon icon="admin-generic" />{ __('Settings', 'locations-and-areas') }</a>
                    </p>
                </div>
            </div>
        ]);
    },
    save: () => { 
        return null // use PHP
    } 
} );