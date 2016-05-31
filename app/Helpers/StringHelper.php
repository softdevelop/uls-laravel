<?php

/**
 * function handleStringtable
 * add style for table
 * @return [type] [description]
 */
function handleStringTable ($text) {
	if (strrpos($text, '<table>') !== false) {
		$text = str_replace('<table>', "<table style='border-collapse: collapse;font-size: 1em;width: 100%;margin: 0;margin-bottom: 15px;border: none;background: none;box-shadow: none;font-size: 14px;line-height: 1.6em;'><tbody>" ,$text);
		$text = str_replace('<td>', "<td style='padding: 5px;border: 1px solid #ddd;vertical-align: top;'>", $text);
		return $text;
	}
	return $text;
}

function dataTemplate()
{
	$data = [
		0 => [
			'_id' => 16,
			'template_name' => 'Template 1',
			'thumbnail' => '/files/images/full_page_template.png',
			'description' => 'Template 1',
			'fields' => [
				[
					'name' => 'Title',
					'variable' => '$title',
					'type'=> 'input',
					'size'=> 50
				]
			],
			'sections' => [
				[
					'name' => 'Main',
					'type' => 'wysiwyg editor',
					'variable' => '$main',
					'file_name' => '5162c30a1aee6a996b5aa7f6d29b88b5.jpg',
				]
			]
		],
		1 => [
			'_id'=> 17,
			'template_name' => 'Template 2',
			'thumbnail' => '/files/images/full_page_template.png',
			'description' => 'Template 1',
			'fields' => [
				[
					'name' => 'Heading',
					'variable' => '$heading',
					'type'=> 'input',
					'size'=> 50
				],
				[
					'name' => 'Subheading',
					'variable' => '$sub_heading',
					'type'=> 'input',
					'size'=> 50
				]
			],
			'sections' => [
				[
					'name' => 'Main',
					'type' => 'wysiwyg editor',
					'variable' => '$main',
					'file_name' => '5162c30a1aee6a996b5aa7f6d29b88b5.jpg'
				],
				[
					'name' => 'Right',
					'type' => 'wysiwyg editor',
					'variable' => '$right',
					'file_name' => '5162c30a1aee6a996b5aa7f6d29b88b5.jpg'
				]
			]
		]
	];

	return $data;
}

function checkIsImage($type)
{
    $images = ['png','gif','jpg', 'jpeg'];

    if(in_array(explode('/', $type)[1], $images))
    	return true;
    
    return false;
}

