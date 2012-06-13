<?php
include_once ( '../3rd/simple_html_dom.php' );
include_once ( 'service_config.php' );

function get_server_announcement($announce_address)
{
	$html = file_get_html($announce_address);
	
	if(null == $html)
	{
		return null;
	}
	
	$top_post = $html->find('td.post-title', 0);
	
	if(null == $top_post)
	{
		return null;
	}
	
	$title = trim($top_post->find('a', 0)->plaintext);
	$content = trim($top_post->find('div.tt_detail', 0)->plaintext);
	
	$ret = array('title' => $title, 'content' => $content);
	return $ret;
}

function write_to_storage_json($filename, $data)
{
	if( null == $filename || null == $data )
	{
		return;
	}
	
	$data_json = json_encode($data);
	
	// write to storage
	if(null != $data_json)
	{
		$s = new SaeStorage();
		$s->write( 'main' , $filename , $data_json );
	}
}

function read_from_storage_json($filename)
{
	if(null == $filename)
	{
		return null;
	}
	
	$s = new SaeStorage();
	$data_json = $s->read( 'main' , $filename);
	return $data_json;
}

function read_from_storage($filename)
{
	if(null == $filename)
	{
		return null;
	}
	
	$data_json = read_from_storage_json($filename);
	if(null == $data_json)
	{
		return null;
	}
	
	$data = json_decode( $data_json, true );
	return $data;
}