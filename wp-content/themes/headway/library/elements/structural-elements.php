<?php
add_action('headway_register_elements', 'headway_register_structural_elements');
function headway_register_structural_elements() {
	
	//Structure
	HeadwayElementAPI::register_group('structure', array(
		'name' => 'Structure'
	));

		HeadwayElementAPI::register_element( array(
			'group'            => 'structure',
			'id'               => 'html',
			'name'             => 'HTML Document',
			'selector'         => 'html',
			'disallow-nudging' => true
		) );

		HeadwayElementAPI::register_element(array(
			'group' => 'structure',
			'id' => 'body',
			'name' => 'Body',
			'selector' => 'body',
			'properties' => array('background', 'borders', 'padding'),
			'disallow-nudging' => true
		));

		HeadwayElementAPI::register_element(array(
			'group' => 'structure',
			'id' => 'wrapper',
			'name' => 'Wrapper',
			'selector' => 'div.wrapper',
			'properties' => array('fonts', 'background', 'borders', 'padding', 'corners', 'box-shadow')
		));

	//Blocks
	HeadwayElementAPI::register_group('blocks', array(
		'name' => 'Blocks',
		'description' => 'Individual block types and block elements'
	));
	
}