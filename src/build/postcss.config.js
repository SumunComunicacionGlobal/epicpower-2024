'use strict';

const process = require( 'process' );

const colors = [
	'primary',
	'primary-100',
	'primary-200',
	'primary-300',
	'primary-400',
	'primary-500',
	'primary-600',
	'secondary',
	'light',
	'lightgray',
	'dark',
	'black',
	'white',
	'gray-dark',
];

module.exports = ( ctx ) => {
	return {
		map: {
			inline: false,
			annotation: true,
			sourcesContent: true,
		},
		plugins: {
			autoprefixer: {
				cascade: false,
				env: 'bs5',
			},
			'postcss-understrap-palette-generator': {
				colors: colors.map( ( x ) => `--${ 'bs-' }${ x }` ),
			},
		},
	};
};
